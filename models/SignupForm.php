<?php

namespace app\models;

use Yii;
use yii\base\Model;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;
    public $phone;
    public $promo_code;
    public $gc;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['promo_code', 'trim'],
            ['promo_code', 'string', 'min' => 1, 'max' => 255],
//            ['phone', 'trim'],
            ['phone', 'required'],
//            ['phone', 'match', 'pattern' => '[0-9]{1,15}', 'message' => 'Что-то не так'],
            ['phone', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This phone number has already been taken.'],
            [['phone'], PhoneInputValidator::className(), 'region' => ['PL', 'UA', 'RU']], //https://github.com/Borales/yii2-phone-input

            ['gc', 'required', 'requiredValue' => 'true', 'message' => 'Invalid capcha'],
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->phone = $this->phone;

        if (($refferal_promocode = ReferralsPromocode::findOne(['promocode'=>$this->promo_code]) )) {
                $user->promocode_id = $refferal_promocode->id;
        }


        $user->setPassword($this->password);
        $user->generateAuthKey();

        $user->email_confirm_token = $user->generateActivationEmailCode($user);
        Yii::$app->errorHandler->logException($user);
        if ($user->save()) {
            return $user;
        }
        return null;
    }

}
