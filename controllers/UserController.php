<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\LoginEmailForm;
use app\models\Notifications;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\User;
use yii\web\UploadedFile;

class UserController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['logout'],
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['profile-settings', 'notifications','set-profile-settings','notification-show'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
//                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function beforeAction($action)
    {
        //$this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm;
        //if ($model->load(Yii::$app->request->post()) && $model->login()) {
        //    return $this->goBack();
        //}

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('singup', ['model' => $model]);
    }
    
    public function actionSignup() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm;
        //if ($model->load(Yii::$app->request->post()) && $model->login()) {
        //    return $this->goBack();
        //}
        $gcapcha = Yii::$app->request->post("g-recaptcha-response", '');
        $model->gc = $this->validateGoogleCapcha($gcapcha);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('singup', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['cabinet/index']);
            //return $this->goHome();
        }

        $model = new LoginEmailForm();
        $model->scenario = 'login';
        $gcapcha = Yii::$app->request->post("g-recaptcha-response", '');
        $model->gc = $this->validateGoogleCapcha($gcapcha);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['cabinet/index']);
            //return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }
    public function actionCheckAccount()
    {
        Yii::$app->response->format = 'json';

        $em = Yii::$app->request->post('email');
        $q = User::find()->where(['email' => $em]);

        if ($q->count() == 0) {
            return 0;
        } else {
            return $q->one()->google_tfa;
        }
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    public function actionNotifications() {
        $this->layout = 'dashboard-layout';
        $data = [];
        $id = Yii::$app->user->getId();

        $data['notifications'] = Notifications::find()->where(['user_id'=>$id])->orderBy('time DESC')->all();

        return $this->render('notifications', $data);
    }
    public function actionNotificationShow() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $id = Yii::$app->user->getId();
            $notification_id = (int)Yii::$app->request->post('id', '');

            $notification = Notifications::find()
                ->where(['id' => $notification_id])
                ->andWhere(['show' => 0])
                ->andWhere(['user_id' => $id]);
            if ($notification->count()) {
                $notification = $notification->one();
                $notification->show = 1;
                if ($notification->save()) {
                    return ['msg' => 'ok'];
                }
            }
            return ['msg' => 'error'];


        }
    }

    private function validateGoogleCapcha($value)
    {
        //TODO: remove after testsВ
//        return true;
        if ($curl = curl_init()) {
            $data = ['secret' => Yii::$app->params['capcha_secret'], 'response' => $value, 'remoteip' => Yii::$app->request->userIP];
            curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            $out = curl_exec($curl);
            curl_close($curl);

            return json_decode($out, true)['success'];
        }
    }
    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionProfileSettings() {
        $this->layout = 'dashboard-layout';
        $id = Yii::$app->user->getId();
        $data = [];
        $data['user'] = User::findOne(['id'=>$id]);

        $model = new LoginEmailForm();
        $model->scenario = 'change-password';
        $model->gc = true;
        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->getSession()->setFlash('success', 'Пароль успешно изменене');
        }
        $model->password = '';
        $model->passwordNew = '';
        $data['model'] = $model;

        return $this->render('profile-settings',$data);
    }
    public function actionSetProfileSettings() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $id                     = Yii::$app->user->getId();
            $user                   = User::findOne(['id'=>$id]);
            $username               = (string)Yii::$app->request->post('username', '');
            $timezone               = (string)Yii::$app->request->post('timezone', '');
            $lang                   = (string)Yii::$app->request->post('lang', '');
            $file                   = UploadedFile::getInstanceByName('file');

            $user->username     = $username;
            $user->timezone     = $timezone;
            $user->lang         = $lang;

            if ($file) {
                if (!is_null($user->logo_src)) {
                    unlink(Yii::getAlias('@webroot') . $user->logo_src);
                }
                $filePath = '/image/users/' . time(). $file->baseName . '.' .$file->extension;
                if ($file->saveAs(Yii::getAlias('@webroot') . $filePath)) {
                    $user->logo_src = $filePath;
                }
            }
            if ($user->save()) {
                return ['msg' => 'ok', 'status' => 'Информация обновленна'];
            } else  {
                return ['msg' => 'error', 'status' => 'Не сохранило изменения'];
            }
        }
    }
    public function actionLanguage ()
    {
        $lang = Yii::$app->request->get('lang');
        if($lang == 'en-US' || $lang == 'ru-RU')
        {
            $session = Yii::$app->session;
            $session->open();
            if ($session->isActive) {
                $session->set('language', $lang);
            }
            \Yii::$app->language = $lang;
            $session->close();
            return $this->redirect(Yii::$app->request->referrer);
        }
        return 'gg';
    }
    public function actionAbout() {
        return $this->render('about');
    }
    
    public function actionEdit() {
        
    }
    
    public function actionSave() {
        
    }

    public function actionPassword() {
        
    }
    
    public function actionRecover() {
        
    }
    
}
