<?php

namespace app\controllers;

use app\models\Notifications;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Marketplace;
use app\models\UserMarketplace;
use app\models\UserMarketplceForm;
use app\models\Currency;
use app\models\CurrencyExchange;
use yii\helpers\Url;
use yii\web\Response;
use app\models\UserMenu;
use app\models\api\google2fa\GoogleAuthenticator;
use app\models\api\google2fa\Rfc6238;
use app\models\User;
use app\models\UserMarkets;

class CabinetController extends Controller
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = [];
        $data['menu'] = $this->menu();

        return $this->render('index', $data);
    }

    public function actionMarketplace()
    {
        $data = [];
        $data['menu'] = $this->menu();

        $marketplace_id = Yii::$app->request->get('marketplace_id', 0);

        $data['marketplace_id'] = $marketplace_id;
        $data['currency']       = [];
        $records = Currency::find()->all();

        foreach ($records as $record) {
            $data['currency'][$record['currency_code']] = [
                'currency_code' => $record['currency_code'],
                'name' => $record['currency_name']
            ];
        }

        $this->view->registerJsFile('/js/flotr2/flotr2.js', ['depends' => ['yii\web\JqueryAsset']]);
        $this->view->registerJsFile('/js/main.js', ['depends' => ['yii\web\JqueryAsset']]);

        return $this->render('marketplace', $data);
    }

    public function actionCourse()
    {
        $marketplace_id = (int) Yii::$app->request->get('marketplace_id', 0);
        $symbol         = Yii::$app->request->get('symbol', '');
        $data           = [];

        if ($marketplace_id && $symbol) {
            $data = CurrencyExchange::find()
                    ->select(['date', 'price'])
                    ->andWhere(['>', 'date', time() - 60 * 60])
                    ->andWhere(['marketplace_id' => $marketplace_id])
                    ->andWhere(['symbol' => $symbol])
                    ->orderBy('date')
                    ->asArray()
                    ->all();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

    public function actionAccounts()
    {
        $data                     = array();
        $data['menu']             = $this->menu();
        $user_id                  = Yii::$app->user->getId();
        $data['user_id']          = $user_id;
        $data['user_marketplace'] = UserMarketplace::find()
                ->select(
                    [
                        'user_marketplace_id',
                        'name',
                        'marketplace_name',
                        'order',
                        'user_market_id',
                        'market_date_end'
                    ]
                )
                ->innerJoin('marketplace', 'marketplace.marketplace_id = user_marketplace.marketplace_id')
                ->where(['user_id' => $user_id])
                ->orderBy('order')
                ->asArray()
                ->all();


        $user_markets = UserMarkets::find()
            ->select('user_markets.count_api,
             user_markets.id,
             market_id,
              user_markets.time_action,
               markets.title,
                markets.cost')
            ->leftJoin('markets', 'markets.id = user_markets.market_id')
            ->where(['user_id' => $user_id])
            ->asArray()
            ->all();

        $data['markets_user'] = $user_markets;

        foreach ($data['user_marketplace'] as &$mp) {
            $mp['edit']   = Url::to(['cabinet/account', 'user_marketplace_id' => $mp['user_marketplace_id']]);
            $mp['delete'] = Url::to(['cabinet/deleteaccount', 'user_marketplace_id' => $mp['user_marketplace_id']]);
            $mp['open']   = Url::to(['usermp/account', 'user_marketplace_id' => $mp['user_marketplace_id']]);
        }

        $data['delete'] = Url::to(['cabinet/deleteaccount']);
        $data['add']    = Url::to(['cabinet/account']);

        return $this->render('accounts', $data);
    }

    public function actionAccount()
    {

        $this->view->registerJsFile('/js/main.js', ['depends' => ['yii\web\JqueryAsset']]);

        $user_id = Yii::$app->user->getId();

        if (Yii::$app->request->isPost && Yii::$app->request->post('UserMarketplceForm')) {
            $model = new UserMarketplceForm();
            if ($model->load(Yii::$app->request->post())) {
                $model->save($user_id);
            }

            return $this->redirect(['cabinet/accounts']);
        }

        $data = array();
        $data['menu'] = $this->menu();
        $data['model'] = new UserMarketplceForm();
        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', null);
        if ($user_marketplace_id) {
            $data['model']->setAttributes(UserMarketplace::findOne([
                'user_marketplace_id' => $user_marketplace_id,
                'user_id' => $user_id])->attributes);
        }
        $data['marketplaces'] = array();
        foreach (Marketplace::find()->asArray()->all() as $value) {
            $data['marketplaces'][$value['marketplace_id']] = $value['marketplace_name'];
        };

        $data["urlMasters"] = Url::toRoute('cabinet/masters');
        return $this->render('account', $data);
    }

    public function actionDeleteaccount()
    {
        $user_id = Yii::$app->user->getId();

        if (Yii::$app->request->isPost && Yii::$app->request->post('user_marketplace_id')) {
            $marketplaces = Yii::$app->request->post('user_marketplace_id', array());

            foreach ($marketplaces as $value) {
                $Marketplace = UserMarketplace::findOne(['user_id' => $user_id, 'user_marketplace_id' => (int)$value]);
                if ($Marketplace) {
                    $Marketplace->delete();
                }
            }
        }
        return $this->redirect(['cabinet/accounts']);
    }

    /**
     * Список Мастер записей
     */
    public function actionMasters()
    {
        $params = [];
        $params['masters'] = [];

        $marketplace_id = (int) Yii::$app->request->post('marketplace_id', 0);
        if ($marketplace_id) {
            $params['masters'] = UserMarketplace::find()
                ->select(['user_marketplace_id', 'marketplace_id', 'name', 'username', 'user_id'])
                ->innerJoin('user', '`user`.`id`=`user_marketplace`.`user_id`')
                ->where(['`user_marketplace`.`master`' => 1, '`user_marketplace`.`marketplace_id`' => $marketplace_id])
                ->asArray()
                ->all();
        }

        return $this->renderPartial('masters', $params);
    }

    public function action2fa()
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(Url::toRoute('/site/login'));
        }
        $params = [];
        $id     = Yii::$app->user->getId();
        $user   = User::find()->where(['id' => $id])->one();

        if (!isset($user->google_se) || !mb_strlen($user->google_se)) {
            $g = new GoogleAuthenticator();
            $user->google_se = $g->generateSecret();
            $user->save();
        }
        $params['user'] = $user;
        $params['qr_url'] = Rfc6238::getBarCodeUrl($user->email,
            Yii::$app->params['project_domain'],
            $user->google_se, Yii::$app->params['project_name']);

        return $this->render('2fa', $params);
    }

    public function actionChangeGoogle(){
        if(!Yii::$app->request->isAjax){
            return $this->redirect('/site/index');
        }
        $data = Yii::$app->request->post();
        Yii::$app->response->format = 'json';

        $id   = Yii::$app->user->getId();
        $user = User::find()->where(['id' => $id])->one();
        if(!isset($data['code']) || !isset($data['secret'])){
            return ['msg' => 'error', 'status' => 'Незаполнены параметры'];
        }
        $g = new GoogleAuthenticator();

        if($g->getCode($data['secret']) == $data['code']){
            if($user->google_tfa == 1){
                $user->google_tfa = 0;
                $user->google_se = $g->generateSecret();
            }else{
                $user->google_tfa = 1;
            }
            if($user->save()){
                $url = Rfc6238::getBarCodeUrl($user->email, Yii::$app->params['project_domain'], $user->google_se, Yii::$app->params['project_name']);
                $notification = new Notifications();
                $notification->createNotification($user->id,
                    'info',
                    $user->google_tfa == 1 ? "Двухфакторная аутентификация включена" : "Двухфакторная аутентификация отключена"
                );

                return [
                    'msg' => 'ok',
                    'data' => [
                        'type' => $user->google_tfa,
                        'url' => $url,
                        'secret' => $user->google_se,
                    ],
                    'status' =>  $user->google_tfa == 1 ? "Двухфакторная аутентификация включена" : "Двухфакторная аутентификация отключена"
                ];
            } else {
                return ['msg' => 'error', 'status' => "Не сохранился юзер"];
            }
        } else {
            return ['msg' => 'error', 'status' => "Неверный код, заного просканируйте код" ];
        }
        return false;
    }

    public function menu()
    {
        return UserMenu::get();
    }
}
