<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\api\google2fa\GoogleAuthenticator;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginEmailForm extends Model
{
    const SCENARIO_CHANGEPASSWORD = 'change-password';
    const SCENARIO_LOGIN = 'login';
    public $email;
    public $password;
    public $passwordNew;
    public $rememberMe = true;
    public $gc;
    public $code;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required', 'on' => self::SCENARIO_LOGIN],
            [['passwordNew', 'password'], 'required', 'on' => self::SCENARIO_CHANGEPASSWORD],
            ['code', 'string'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword', 'on' => self::SCENARIO_LOGIN],
            ['password', 'validatePassword2', 'on' => self::SCENARIO_CHANGEPASSWORD],

            ['gc', 'required', 'requiredValue' => 'true', 'message' => 'Invalid capcha'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'passwordNew' => 'Новый пароль',
        ];
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user) {
                $this->addError('code', 'Incorrect code');
                return false;
            }
            if(!$user->validatePassword($this->password)){
                $notification = new Notifications();
                $notification->createNotification($user->id,
                    'notification',
                    'Неудачная попытка входа, неверный пароль IP = '
                    .$_SERVER['REMOTE_ADDR']
                    . ' Браузер: '
                    .$_SERVER['HTTP_USER_AGENT'],
                    $_SERVER['HTTP_USER_AGENT']);

                $this->addError($attribute, 'Incorrect email or password.');
                return false;
            }
            $notification = new Notifications();
            $notification->createNotification($user->id,
                'success',
                'Успешный вход IP = '
                .$_SERVER['REMOTE_ADDR']
                . ' Браузер: '
                .$_SERVER['HTTP_USER_AGENT'],
                $_SERVER['HTTP_USER_AGENT']);
        }
    }


    public function validatePassword2($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if(!Yii::$app->user->identity->validatePassword($this->password)){
                $this->addError($attribute, 'Incorrect password.');
                return false;
            }
            if(Yii::$app->user->identity->google_tfa == 1)
            {
                $g = new GoogleAuthenticator();
                if($g->getCode(Yii::$app->user->identity->google_se) != $this->code){
                    $this->addError('code', 'Неверный код');
                    return false;
                }
            }
        }
    }
    public function changePassword()
    {
        if ($this->validate()) {
            Yii::$app->user->identity->setPassword($this->passwordNew);
            if (Yii::$app->user->identity->save()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            //$this->_user = User::findByUsername($this->username);
            $this->_user = User::findByEmail($this->email);
            if($this->_user !== null)
            {
                if($this->_user->google_tfa == 1)
                {
                    $g = new GoogleAuthenticator();
                    if($g->getCode($this->_user->google_se) != $this->code){
                        $notification = new Notifications();
                        $notification->createNotification($this->_user->id,
                            'notification',
                            'Неудачная попытка входа, неверный пароль Google2Fa, IP = '
                            .$_SERVER['REMOTE_ADDR']
                            . ' Браузер: '
                            .$_SERVER['HTTP_USER_AGENT'],
                            $_SERVER['HTTP_USER_AGENT']);
                        return null;
                    }
                }
//                $this->username = $this->_user->username;
            } else {
                $this->addError('email', 'User does not exist or incorrect password.');
            }
        }

        return $this->_user;
    }
}
