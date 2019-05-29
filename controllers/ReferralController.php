<?php

namespace app\controllers;

use app\models\ReferralsPromocode;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\widgets\Menu;
use app\models\Marketplace;
use app\models\UserMarketplace;
use app\models\UserMarketplceForm;
use app\models\Currency;
use app\models\CurrencyExchange;
use yii\helpers\Url;
use yii\web\Response;
use app\models\UserMenu;

class ReferralController extends UserAccessController {

    public $layout = 'dashboard-layout';

    public function behaviors() {
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $id = Yii::$app->user->getId();

        $data = [];
        $data['promocodes'] = ReferralsPromocode::findAll(['user_id'=>$id]);
        $data['user_referrals'] = User::find()
            ->select(['username', 'referrals_promocode.promocode','user.created_at'])
            ->leftJoin('referrals_promocode', 'referrals_promocode.id = user.promocode_id')
            ->where(['referrals_promocode.user_id' => $id])
//            ->where(['referrals_promocode.id' => 'user.promocode_id'])
            ->asArray()
            ->all();

        return $this->render('index', $data);
    }

    public function actionCreatePromocode() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';

            $id         = (int)Yii::$app->user->getId();
            $promocode  = (string)Yii::$app->request->post('promocode', '');

            $refferal_promocode             = new ReferralsPromocode();
            $refferal_promocode->promocode  = $promocode;
            $refferal_promocode->user_id    = $id;

            if (!$refferal_promocode->save()) {
                return ['msg' => 'error', 'status' => "Не сохранен промокод (возможно уже есть такой промокод)"];
            }
            return ['msg' => 'ok', 'status' => 'Промокод сохранен успешно', 'result' => $refferal_promocode];
        }
    }

    public function actionDeletePromocode() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';

            $id = Yii::$app->user->getId();
            $promocode_id = (int)Yii::$app->request->post('promocode_id', null);

            if (!($refferal_promocode = ReferralsPromocode::findOne(['id'=>$promocode_id]) )) {
                return ['msg' => 'error', 'status' => "Не найден промокод"];
            }
            if ($refferal_promocode->user_id !== $id) {
                return ['msg' => 'error', 'status' => "Не ваш промокод"];
            }
            if (ReferralsPromocode::haveReferral($refferal_promocode->id)) {
                return ['msg' => 'error', 'status' => 'По промокоду уже пришли люди'];
            }

            if ($refferal_promocode->delete()) {
                return ['msg' => 'ok', 'status' => "Промокод удален"];
            } else {
                return ['msg' => 'error', 'status' => "Промокод не удален"];
            }
        }
    }



}
