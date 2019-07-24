<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property integer $promocode_id
 * @property string $user_role
 * @property string $username
 * @property string $telegram
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email_confirm_token
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property string $lang
 * @property string $logo_src
 * @property string $timezone
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_WAIT_ACTIVATION = 1;
    const STATUS_ACTIVE = 10;
    const ROLES = [
        'user','globalAdmin','admin','moderator','client-trader','client-ad'
    ];
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => TimestampBehavior::className(),
//                'createdAtAttribute' => 'created_at',
//                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return date('Y-m-d h:m:s');
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_WAIT_ACTIVATION],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_WAIT_ACTIVATION, self::STATUS_DELETED]],
            [['file'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => [self::STATUS_ACTIVE,self::STATUS_WAIT_ACTIVATION]]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
//        return static::findOne(['username' => $username]);
        return static::findOne(['username' => $username, 'status' => [self::STATUS_ACTIVE,self::STATUS_WAIT_ACTIVATION]]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => [self::STATUS_ACTIVE,self::STATUS_WAIT_ACTIVATION]]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public static function canAdmin()
    {
        if (Yii::$app->user->identity->user_role == "globalAdmin" ||
            Yii::$app->user->identity->user_role == "admin" ) {
            return true;
        } else {
            return false;
        }
    }
    public static function canModerate()
    {
        if (Yii::$app->user->identity->user_role == "globalAdmin" ||
            Yii::$app->user->identity->user_role == "admin" ||
            Yii::$app->user->identity->user_role == "moderator") {
            return true;
        } else {
            return false;
        }
    }
    public static function allowedCurrency($curr)
    {
        $wordsArray = ['USDT','BTC','ETH'];
        if(in_array($curr,$wordsArray)){
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }



    public function generateActivationEmailCode(User $user){
        $this->email_confirm_token = Yii::$app->security->generateRandomString(16);

        $email = $user->email;
        $sent = Yii::$app->mailer
            ->compose(
                ['html' => 'user-signup-confirm-html'],//, 'text' => 'user-signup-confirm-text'
                ['user' => $user])
            ->setTo($email)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject('Confirmation of registration')
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Sending error.');
        }
        return $this->email_confirm_token;
    }

    public static function confirmation($token): void
    {
        if (empty($token)) {
            throw new \DomainException('Требуется подтверждение email');
        }

        $user = User::findOne(['email_confirm_token' => $token]);
        if (!$user) {
            throw new \DomainException('User is not found.');
        }

        $user->email_confirm_token = null;
        $user->status = User::STATUS_ACTIVE;
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }

        if (!Yii::$app->getUser()->login($user)){
            throw new \RuntimeException('Error authentication.');
        }
    }






    public function getMarketplace()
    {
        return $this->hasMany(UserMarketplace::className(), ['user_marketplace_id' => 'user_marketplace_id'])
            ->viaTable('user_marketplace_buy', ['user_id' => 'id']);
    }

}
