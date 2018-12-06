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

class UserController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['cabinet/index']);
            //return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
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
    /**
     * Displays about page.
     *
     * @return string
     */
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
