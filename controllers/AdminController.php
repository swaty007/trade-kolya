<?php

namespace app\controllers;

use app\models\AdminSettings;
use app\models\Categories;
use app\models\Notifications;
use app\models\ReferralsPromocode;
use app\models\Transactions;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\Tags;
use app\models\UserMarketplace;

class AdminController extends UserAccessController
{
    public $layout = 'dashboard-layout';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        //'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        if (!User::canAdmin()) {
            $this->redirect(Url::toRoute('/site/index'));
            return false;
        }
        //$this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
        if (User::canAdmin()) {
            $data = [];
            $id = Yii::$app->user->getId();
            $user_id                = (int)Yii::$app->request->get('user_id', null);

            $data['categories']     = Categories::find()->where(['parent_id' => null])->all();
            $data['sub_categories'] = Categories::find()->where(['not', ['parent_id' => null]])->all();
            $data['full_tags']      = Tags::find()->all();
            $items = '';
            foreach ($data['full_tags'] as $tag) {
                $items .= $tag->tag_name . ',';
            }
            $data['tags']  = substr($items, 0, (strlen($items)-1));


            $data['user_referrals'] = User::find()
                ->select(['user.username', 'referrals_promocode.promocode','user.created_at','user1.username as username_parent'])
                ->leftJoin('referrals_promocode', 'referrals_promocode.id = user.promocode_id')
                ->leftJoin('user as user1', 'referrals_promocode.user_id = user1.id')
                ->where(['!=','user.promocode_id', ''])
                ->asArray()
                ->all();

            $data['types'] = ['api','telegram'];
            $data['user_marketplace'] = UserMarketplace::find()
                ->select(['user_marketplace_id', 'name', 'marketplace_name'])
                ->innerJoin('marketplace', 'marketplace.marketplace_id = user_marketplace.marketplace_id')
                ->where(['user_id' => $id])
                ->andWhere(['user_market_id' => 0])
                ->orderBy('order')
                ->asArray()
                ->all();

            $data['users'] = User::find()->all();
            $data['user_single'] = User::find()->where(['id'=>$user_id])->one();
            $data['admin_settings'] = AdminSettings::find()->all();


            $data['notifications'] = Notifications::find()->where(['user_id'=>$user_id])->orderBy('time DESC')->all();
            $data['transactions_single'] = Transactions::find()
                ->where(['user_id'=>$user_id])
                ->andWhere(['!=','status',Transactions::STATUS_WAIT_EMAIL_ACTIVATION])
                ->orderBy('date_start DESC')->all();

            if (User::canAdmin()) {
                $data['transactions'] = Transactions::find()
                    ->where(['!=','status',Transactions::STATUS_WAIT_EMAIL_ACTIVATION])
                    ->orderBy('date_start DESC')->all();
            }

            return $this->render('index', $data);
        } else {
            return ['msg' => 'error', 'status' => "Dont have asses"];
        }
    }
    public function actionBanUser()
    {
        if (Yii::$app->request->isAjax) {
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';

                $user_id = (int)Yii::$app->request->post('user_id', '');
                $ban_user = (int)Yii::$app->request->post('status', null);

                if (!($user = User::findOne(['id'=>$user_id]) )) {
                    return ['msg' => 'error', 'status' => "No user finded"];
                }

                if ($ban_user === 0) {
                    $user->status = 0;
                    $status_text = "Юзер забанен";
                } elseif ($ban_user === 10) {
                    $user->status = 10;
                    $status_text = "Юзер разбанен";
                }

                if ($user->save()) {
                    return ['msg' => 'ok','status' => $status_text , 'user' => $user];
                } else {
                    return ['msg' => 'error','status'=>'При сохранении произошла ошибка', 'user' => $user];
                }

            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }
    public function actionChangeSetting()
    {
        if (Yii::$app->request->isAjax) {
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';

                $setting_id = (int)Yii::$app->request->post('id', '');
                $value = (string)Yii::$app->request->post('value', '');

                if (!($setting = AdminSettings::findOne(['id'=>$setting_id]) )) {
                    return ['msg' => 'error', 'status' => "No setting finded"];
                }
                $setting->value = $value;

                if ($setting->save()) {
                    return ['msg' => 'ok','status'=>'Настройка сохранена', 'setting' => $setting];
                } else {
                    return ['msg' => 'error','status'=>'При сохранении произошла ошибка', 'setting' => $setting];
                }

            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }
}
