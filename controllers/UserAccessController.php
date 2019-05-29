<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\LoginEmailForm;
use app\models\Notifications;
use app\models\SignupForm;
use app\models\ContactForm;
use yii\web\UploadedFile;
use yii\helpers\Url;

class UserAccessController extends Controller {
    public function beforeAction($action)
    {
        //$this->enableCsrfValidation = false;
        if((int)Yii::$app->user->identity->status === (int)User::STATUS_WAIT_ACTIVATION && $this->getRoute() != 'user/activation'){
            return $this->redirect(['user/activation']);
        }
        return parent::beforeAction($action);
    }

}
