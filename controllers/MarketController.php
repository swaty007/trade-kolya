<?php

namespace app\controllers;

use app\models\Transactions;
use app\models\User;
use app\models\UserMarkets;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Markets;
use app\models\UserMarketplace;

class MarketController extends Controller
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
                        'allow' => false,
                        //'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        //'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCron()
    {
        $today = date('Y-m-d');
        foreach (UserMarketplace::find()->where(['<>', 'user_market_id', 0])->all() as $marketplace) {
            if ($today > $marketplace->market_date_end) {
                $marketplace->user_market_id = 0;
                if ($marketplace->save()) {
                    Yii::trace("Status changed");
                } else {
                    Yii::error("Status changed ERROR");
                }
            }
        }
    }

    public function actionIndex()
    {
        $data                    = [];
        $id                      = Yii::$app->user->getId();
        $data['markets_active']  = Markets::find()->where(['status' => 'active'])->orderBy('date_update DESC')->all();
        $data['markets_archive'] = Markets::find()->where(['status' => 'archive'])->orderBy('date_update DESC')->all();

        $users_markets_ids = [];

        foreach (UserMarkets::find()->where(['user_id' => $id])->select(['market_id'])->all() as $users_markets_id) {
            $users_markets_ids[] = $users_markets_id->market_id;
        }

        $data['markets_user'] = Markets::find()
            ->where(['IN','id',$users_markets_ids])
            ->orderBy('date_update DESC')
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

        return $this->render('index', $data);
    }

    public function actionCreateMarket()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $id          = Yii::$app->user->getId();
            $title       = (string)Yii::$app->request->post('title', '');
            $type        = (string)Yii::$app->request->post('type', '');
            $description = (string)Yii::$app->request->post('description', '');
            $cost        = (double)Yii::$app->request->post('cost', 0);
            $time_action = (int)Yii::$app->request->post('time_action', '');
            $count_api   = (int)Yii::$app->request->post('count_api', '');

            $market              = new Markets();
            $market->title       = $title;
            $market->type        = $type;
            $market->description = $description;
            $market->cost        = $cost;
            $market->time_action = $time_action;
            $market->count_api   = $count_api;

            if ($market->save()) {
                return ['msg' => 'ok', 'status' => 'Маркет создан', 'market' => $market];
            } else {
                return ['msg' => 'error', 'status' => 'Маркет не сохранился', 'market' => $market];
            }
        }
    }

    public function actionUpdateMarket()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->user->getId();
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';

                $market_id   = (int)Yii::$app->request->post('market_id', '');
                $title       = (string)Yii::$app->request->post('title', '');
                $type        = (string)Yii::$app->request->post('type', '');
                $description = (string)Yii::$app->request->post('description', '');
                $cost        = (double)Yii::$app->request->post('cost', 0);
                $time_action = (int)Yii::$app->request->post('time_action', '');
                $count_api   = (int)Yii::$app->request->post('count_api', '');

                if (!($market = Markets::findOne(['id'=>$market_id]) )) {
                    return ['msg' => 'error', 'status' => "No Market finded"];
                }

                $market->title       = $title;
                $market->type        = $type;
                $market->description = $description;
                $market->cost        = $cost;
                $market->time_action = $time_action;
                $market->count_api   = $count_api;

                if ($market->save()) {
                    return ['msg' => 'ok', 'status' => "Market updated"];
                } else {
                    return ['msg' => 'error', 'status' => "Market don't updated"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }
    public function actionDeleteMarket()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->user->getId();
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';
                $market_id = (int)Yii::$app->request->post('market_id', '');

                if (!($market = Markets::findOne(['id'=>$market_id]) )) {
                    return ['msg' => 'error', 'status' => "No market finded"];
                }

                if (Markets::haveInvest($market->id)) {
                    $market->status = 'archive';
                    if (!($market->save())) {
                        return ['msg' => 'error', 'status' => "Market don't saved"];
                    }
                    return ['msg' => 'error', 'status' => 'Have money in invest => moved to archive'];
                } else {
                    if ($market->delete()) {
                        return ['msg' => 'ok', 'status' => "Market deleted"];
                    } else {
                        return ['msg' => 'error', 'status' => "Market don't deleted"];
                    }
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }


    public function actionBuyMarketplace()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $id            = Yii::$app->user->getId();
            $market_id     = (int)Yii::$app->request->post('market_id', '');
            $invest_method = "USDT";

            if (!($market = Markets::findOne(['id'=>$market_id]) )) {
                return ['msg' => 'error', 'status' => "No Market finded"];
            }

            $user = User::find()->where(['id' => $id])->one();

            if ($market->status === 'archive') {
                return ['msg' => 'error', 'status' => "Archive Market"];
            }

            if (User::allowedCurrency($invest_method)) {
                if ($user->{$invest_method.'_money'} < $market->cost) {
                    return ['msg' => 'error', 'status' => "Don't have balance"];
                }
                $user->{$invest_method.'_money'} -= $market->cost;
            } else {
                return ['msg' => 'error', 'status' => "Failed currency"];
            }

            if (!$user->save()) {
                return ['msg' => 'error', 'status' => "User don't save"];
            }

            $user_market              = new UserMarkets();
            $user_market->user_id     = $user->id;
            $user_market->market_id   = $market->id;
            $user_market->count_api   = $market->count_api;
            $user_market->time_action = $market->time_action; //($market->time_action*(60*60*24))
            if (!$user_market->save()) {
                return ['msg' => 'error', 'status' => "User Market don't save"];
            }

            $transaction              = new Transactions();
            $transaction->type        = 'market';
            $transaction->user_id     = $id;
            $transaction->status      = 1;
            $transaction->amount1     = $market->cost;
            $transaction->currency1   = $invest_method;
            $transaction->buyer_name  = Yii::$app->user->identity->username;
            $transaction->buyer_email = Yii::$app->user->identity->email;

            $transaction->save();

            return ['msg' => 'ok', 'status' => 'Marketplace buyed'];
        }
    }

    public function actionMarketplaceToApi()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $id             = Yii::$app->user->getId();
            $marketplaces   = (array)Yii::$app->request->post('marketplace', 0);
            $user_market_id = (array)Yii::$app->request->post('user_market_id', 0);
            $today          = date('Y-m-d');

            if (!($user_market = UserMarkets::findOne(['id'=>$user_market_id,'user_id'=>$id]) )) {
                return ['msg' => 'error', 'status' => "No User Market finded"];
            }

            $user_marketplaces_count = UserMarketplace::find()
                ->where(['user_id' => $id])
                ->andWhere(['IN','user_marketplace_id',$marketplaces])
                ->andWhere(['user_market_id' => 0])
                ->count();

            if ((int)count($marketplaces) > (int)$user_market->count_api
                || (int)$user_marketplaces_count !== (int)count($marketplaces)
            ) {
                return ['msg' => 'error', 'status' => "False count API or Marketplace"];
            }

            $days_with_action = (int)(strtotime($today) + ($user_market->time_action*(60*60*24)));
            foreach ($marketplaces as $marketplace) {
                $u_marketplace = UserMarketplace::find()
                    ->where(['user_id' => $id])
                    ->andWhere(['user_market_id' => 0])
                    ->andWhere(['user_marketplace_id'=>$marketplace])
                    ->one();
                $u_marketplace->user_market_id  = $user_market->id;
                $u_marketplace->market_date_end = date('Y-m-d', $days_with_action);

                $user_market->count_api -= 1;
                if (!$user_market->save()) {
                    return ['msg' => 'error', 'status' => "Don't save user market"];
                }
                if (!$u_marketplace->save()) {
                    $user_market->count_api += 1;
                    $user_market->save();
                    return ['msg' => 'error', 'status' => "Don't save marketplace"];
                }
            }

        }
    }

}