<?php

namespace app\controllers;

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

class CabinetController extends Controller {

    public $layout = 'dashboard-layout';

    public function behaviors() {
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
    public function actionIndex() {

        $data = [];
        $data['menu'] = $this->menu();

        return $this->render('index', $data);
    }

    public function actionMarketplace() {
        $data = [];
        $data['menu'] = $this->menu();

        $marketplace_id = Yii::$app->request->get('marketplace_id', 0);

        $data['marketplace_id'] = $marketplace_id;
        $data['currency'] = [];
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

    public function actionCourse() {

        $marketplace_id = (int) Yii::$app->request->get('marketplace_id', 0);
        $symbol = Yii::$app->request->get('symbol', '');

        $data = [];

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

    public function actionAccounts() {

        $data = array();
        $data['menu'] = $this->menu();
        $user_id = Yii::$app->user->getId();
        $data['user_id'] = $user_id;
        $data['user_marketplace'] = UserMarketplace::find()
                ->select(['user_marketplace_id', 'name', 'marketplace_name', 'order',  'market_id', 'market_date_end'])
                ->innerJoin('marketplace', 'marketplace.marketplace_id = user_marketplace.marketplace_id')
                ->where(['user_id' => $user_id])
                ->orderBy('order')
                ->asArray()
                ->all();


        foreach ($data['user_marketplace'] as &$mp) {
            $mp['edit'] = Url::to(['cabinet/account', 'user_marketplace_id' => $mp['user_marketplace_id']]);
            $mp['delete'] = Url::to(['cabinet/deleteaccount', 'user_marketplace_id' => $mp['user_marketplace_id']]);
            $mp['open'] = Url::to(['usermp/account', 'user_marketplace_id' => $mp['user_marketplace_id']]);
        }

        $data['delete'] = Url::to(['cabinet/deleteaccount']);
        $data['add'] = Url::to(['cabinet/account']);
        ///print_r($data['user_marketplace']);
        //exit;

        return $this->render('accounts', $data);
    }

    public function actionAccount() {

        $this->view->registerJsFile('/js/main.js', ['depends' => ['yii\web\JqueryAsset']]);

        $user_id = Yii::$app->user->getId();
        //print_r(Yii::$app->request->post());
        //exit;
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
            //print_r(UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->attributes);
            //exit;
            $data['model']->setAttributes(UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->attributes);
            //print_r($data['model']);
            //exit;
        }
        $data['marketplaces'] = array();
        foreach (Marketplace::find()->asArray()->all() as $value) {
            $data['marketplaces'][$value['marketplace_id']] = $value['marketplace_name'];
        };

        $data["urlMasters"] = Url::toRoute('cabinet/masters');
        return $this->render('account', $data);
    }

    public function actionDeleteaccount() {

        $user_id = Yii::$app->user->getId();

        if (Yii::$app->request->isPost && Yii::$app->request->post('user_marketplace_id')) {

            $marketplaces = Yii::$app->request->post('user_marketplace_id', array());

            foreach ($marketplaces as $value) {
                $Marketplace = UserMarketplace::findOne(['user_id' => $user_id, 'user_marketplace_id' => (int)$value]);
                if ($Marketplace){
                    $Marketplace->delete();                            
                }
            }
        }
        return $this->redirect(['cabinet/accounts']);
    }

    /**
     * Список Мастер записей
     */
    public function actionMasters() {

        $params = [];
        $params['masters'] = [];

        $marketplace_id = (int) Yii::$app->request->post('marketplace_id', 0);
        if ($marketplace_id) {
            $params['masters'] = UserMarketplace::find()->select(['user_marketplace_id', 'marketplace_id', 'name', 'username', 'user_id'])->innerJoin('user', '`user`.`id`=`user_marketplace`.`user_id`')->where(['`user_marketplace`.`master`' => 1, '`user_marketplace`.`marketplace_id`' => $marketplace_id])->asArray()->all();
        }

        //print_r($params['masters']);
        //exit;

        return $this->renderPartial('masters', $params);
    }

    public function menu() {

        return UserMenu::get();
        //$menu = new UserMenu;
        //return $menu->get();
    }

}

