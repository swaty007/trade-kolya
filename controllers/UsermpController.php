<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\LoginEmailForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\UserMenu;
use app\models\UserTask;
use app\models\UserMarketplace;
use app\models\Marketplace;
use app\models\Currency;
use yii\helpers\Url;
use app\components\Binance\Api;
use yii\db\Expression;
use app\models\api\Poloniex;

class UsermpController extends Controller {

    public $layout = 'dashboard-layout';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        
    }

    public function actionStat() {
        
        $this->view->registerJsFile('/js/flotr2/flotr2.js', ['depends' => ['yii\web\JqueryAsset']]);
        $this->view->registerJsFile('/js/trade.js', ['depends' => ['yii\web\JqueryAsset']]);
        
        $user_id = Yii::$app->user->getId();
        $UserMarketplaces = UserMarketplace::findAll(['user_id' => $user_id]);

        $data = array();
        
        $data["flotr_data"] = array();
        
        foreach ($UserMarketplaces as $UserMarketplace) {
            $api = $this->getClassApi($UserMarketplace->marketplace_id, $UserMarketplace->key, $UserMarketplace->secret);


            $balance = $api->getBalancesUSD();

            $d = array();
            foreach ($balance as $currency => $value) {
                $d[] = array(
                    'data' => array(array(0, $value['usd'])),
                    'label' => $currency
                );
            }

            //print_r();
            $Marketplace['user_marketplace_id'] = $UserMarketplace->user_marketplace_id;
            $Marketplace['marketplace_id'] = $UserMarketplace->marketplace_id;
            $Marketplace['name'] = $UserMarketplace->name;
            $Marketplace['balance'] = $balance;

            $Marketplace['data'] = $d;

            $data['marketplaces'][] = $Marketplace;
            
            $data["flotr_data"][] = array(
                'user_marketplace_id' => $UserMarketplace->user_marketplace_id,
                'data' => $d
            );
        }

        $data['menu'] = UserMenu::get();

        return $this->render('stat', $data);
    }

    public function actionTrades() {
        $user_id = Yii::$app->user->getId();

        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);
        $symbol = Yii::$app->request->get('symbol', '');

        $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();
        $api = $this->getClassApi($UserMarketplace['marketplace_id'], $UserMarketplace['key'], $UserMarketplace['secret']);

        //$api = new Api($UserMarketplace['key'], $UserMarketplace['secret']);
        //$openorders = $api->openOrders("BNBBTC");
        //print_r($openorders);
        //$trades = $api->aggTrades("BNBUSDT");

        $trades = $api->getTrades($symbol);
        //$trades = array_reverse($trades);
        //print_r($trades);
        //exit;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $trades;

        //print_r($history);
        //exit;
        //$trades = $api->orders("BNBUSDT");
        //print_r($trades);
    }

    public function actionOpenorder() {

        $user_id = Yii::$app->user->getId();

        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);
        $symbol = Yii::$app->request->get('symbol', 'BNBUSDT');

        $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();

        $api = new Api($UserMarketplace['key'], $UserMarketplace['secret']);

        $orders = $api->openOrders($symbol);

        //print_r($orders);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $orders;
    }

    public function actionOrder() {

        $user_id = Yii::$app->user->getId();

        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);
        $symbol = Yii::$app->request->get('symbol', '');

        $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();

        $api = new Api($UserMarketplace['key'], $UserMarketplace['secret']);

        $orders = $api->orders($symbol);

        //print_r($orders);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $orders;
    }

    public function actionCancelorder() {

        $user_id = Yii::$app->user->getId();
        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);
        $symbol = Yii::$app->request->get('symbol', '');
        $orderId = Yii::$app->request->get('orderId', '');

        $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();

        $api = new Api($UserMarketplace['key'], $UserMarketplace['secret']);

        $order = $api->cancel($symbol, $orderId);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $order;
    }

    public function actionDepth() {
        $user_id = Yii::$app->user->getId();

        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);
        $symbol = Yii::$app->request->get('symbol', '');

        $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();
        $api = $this->getClassApi($UserMarketplace['marketplace_id'], $UserMarketplace['key'], $UserMarketplace['secret']);

        //$api = new Api($UserMarketplace['key'], $UserMarketplace['secret']);
        //$openorders = $api->openOrders("BNBBTC");
        //print_r($openorders);
        //$trades = $api->aggTrades("BNBUSDT");
        $depth = $api->getDepth($symbol);
        //$depth = $api->depth($symbol);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $depth;

        //print_r($history);
        //exit;
        //$trades = $api->orders("BNBUSDT");
        //print_r($trades);
    }

    private function getClassApi($marketplace_id, $key, $secret) {
        $Marketplace = Marketplace::findOne(['marketplace_id' => $marketplace_id])->toArray();

        $class = 'app\\models\\api\\' . $Marketplace['marketplace_class'];

        $api = new $class($key, $secret);

        return $api;
    }

    public function actionTicks() {

        $user_id = Yii::$app->user->getId();

        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);
        $symbol = Yii::$app->request->get('symbol', '');

        $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();
        $api = $this->getClassApi($UserMarketplace['marketplace_id'], $UserMarketplace['key'], $UserMarketplace['secret']);

        $config = array();
        $config['time'] = "1m";

        $data = $api->getTicks($symbol, $config);

        //print_r($data); exit;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

    public function actionBalance() {

        $user_id = Yii::$app->user->getId();
        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);

        $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();
        $api = $this->getClassApi($UserMarketplace['marketplace_id'], $UserMarketplace['key'], $UserMarketplace['secret']);

        //$api = new Api($UserMarketplace['key'], $UserMarketplace['secret']);
        //$balance = $api->balances();
        $balance = $api->getBalances();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $balance;
    }
    
    public function action24h() {

        $user_id = Yii::$app->user->getId();
        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);
        $symbol = Yii::$app->request->get('symbol', '');

        $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();
        $api = $this->getClassApi($UserMarketplace['marketplace_id'], $UserMarketplace['key'], $UserMarketplace['secret']);

        //$api = new Api($UserMarketplace['key'], $UserMarketplace['secret']);
        //$balance = $api->balances();
        $balance = $api->get24h($symbol);
        //print_r($balance);exit;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $balance;
        
    }

    private function getActionConfigDefault() {
        return array(
            'action' => 'buy', // sell
            'symbol' => '',
            'quantity' => 0,
            'price' => 0,
            'type' => 'LIMIT',
            'flags' => [],
            'key' => '',
            'secret' => ''
        );
    }

    private function setActionPostData(&$config) {


        if (!Yii::$app->request->isPost) {
            $this->setError('No POST DATA');
            return false;
        }

        $symbol = Yii::$app->request->post('symbol', '');
        if ($symbol) {
            $config['symbol'] = $symbol;
        } else {
            $this->setError('Не указаны валюты');
        }

        $price = (float) Yii::$app->request->post('price', 0);
        if ($price) {
            $config['price'] = $price;
        }

        $quantity = (float) Yii::$app->request->post('quantity', 0);
        if ($quantity) {
            $config['quantity'] = $quantity;
        } else {
            $this->setError('не указано количество');
        }

        $type = Yii::$app->request->post('type', 'LIMIT'); //MARKET
        if ($type == 'MARKET') {
            $config['type'] = 'MARKET';
            $config['price'] = 0;
        } else {
            $config['type'] = 'LIMIT';
        }

        $stopPrice = Yii::$app->request->post('stopPrice', false);
        if ($stopPrice) {
            $config['flags']['stopPrice'] = $stopPrice;
        }

        if ($this->error) {
            return false;
        } else {
            return true;
        }
    }

    private $error = [];

    private function setError($message) {
        $this->error[] = $message;
    }

    private function setActionKeySecure(&$config, $user_id, $user_marketplace_id) {

        $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();

        if ($UserMarketplace) {
            $config['key'] = $UserMarketplace['key'];
            $config['secret'] = $UserMarketplace['secret'];
            return true;
        } else {
            $this->setError('No marketplace for user');
            return false;
        }
    }

    private function executeAction($config) {

        $api = new Api($config['key'], $config['secret']);

        ob_start();
        if ($config['action'] == 'buy') {
            $order = $api->buy($config['symbol'], $config['quantity'], $config['price'], $config['type'], $config['flags']);
        } elseif ($config['action'] == 'sell') {
            $order = $api->sell($config['symbol'], $config['quantity'], $config['price'], $config['type'], $config['flags']);
        }
        ob_end_clean();

        return $order;
    }

    private function executeActionRequest($config) {

        $result = [];

        $user_id = Yii::$app->user->getId();
        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);

        if ($this->setActionPostData($config) && $this->setActionKeySecure($config, $user_id, $user_marketplace_id)) {
            $result['order'] = $this->executeAction($config);
            if (isset($result['order']['msg'])) {
                $this->setError($result['order']['msg']);
            }
        }

        if ($this->error) {
            $result['success'] = false;
            $result['message'] = $this->error;
        } else {
            $result['success'] = true;
            $TaskId = $this->writeTask($config, $result, $user_id, $user_marketplace_id, 0, 0);
            $this->executeActionSlave($TaskId);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * 
     * 
     */
    private function executeActionSlave($TaskId) {
        $Task = UserTask::findOne(['user_task_id' => $TaskId]);
        $Slaves = UserMarketplace::findAll(['slave' => $Task->user_marketplace_id]);

        $config = json_decode($Task->config);
        foreach ($Slaves as $Slave) {
            $config['key'] = $Slave->key;
            $config['secret'] = $Slave->secret;

            $result = [];

            $result['order'] = $this->executeAction($config);
            if (isset($result['order']['msg'])) {
                $result['error'][] = $result['order']['msg'];
                $result['success'] = false;
            } else {
                $result['success'] = true;
            }
            $this->writeTask($config, $result, $Slave->user_id, $Slave->user_marketplace_id, $Task->user_task_id, $Task->user_marketplace_id);
        }
    }

    /**
     * Запись выполнения задачи
     * @param arr $config масив с параметрами
     * @param arr $result масив с результатом
     * @param int $user_marketplace_id id настроек аккаунта
     * 
     * @return int user_task_id добавленой записи
     */
    private function writeTask($config, $result, $user_id, $user_marketplace_id, $parent_user_task_id = 0, $master_user_marketplace_id = 0) {

        $config['key'] = '';
        $config['secret'] = '';

        $Task = new UserTask();

        $Task->parent_user_task_id = (int) $parent_user_task_id;
        $Task->user_id = (int) $user_id;
        $Task->user_marketplace_id = (int) $user_marketplace_id;
        $Task->master_user_marketplace_id = (int) $master_user_marketplace_id;

        $Task->config = json_encode($config);
        $Task->result = json_encode($result);
        $Task->succcess = (isset($result['success']) && $result['success']) ? 1 : 0;

        $Task->date_create = new Expression('NOW()');
        $Task->date_edit = new Expression('NOW()');

        $Task->save();

        return $Task->user_task_id;
    }

    public function actionBuy() {

        $config = $this->getActionConfigDefault();

        $config['action'] = 'buy';

        return $this->executeActionRequest($config);

        /*
          if (Yii::$app->request->isPost) {

          $this->setParam($config, $error);

          if ($error) {
          $result['success'] = false;
          $result['message'] = $error;
          return $result;
          }

          $result['success'] = true;
          $result['order'] = $this->execBuy($config);
          if (isset($result['order']['msg'])) {
          $result['success'] = false;
          $result['message'][] = $result['order']['msg'];
          }
          return $result;
          } else {
          $result['success'] = false;
          $result['message'][] = 'Нет данных';
          return $result;
          }
         * 
         */
    }

    public function actionSell() {

        $config = $this->getActionConfigDefault();

        $config['action'] = 'sell';

        return $this->executeActionRequest($config);

        /*
          $config = array(
          'symbol' => '',
          'quantity' => 0,
          'price' => 0,
          'type' => 'LIMIT',
          'flags' => []
          );

          Yii::$app->response->format = Response::FORMAT_JSON;
          $result = [];
          $error = [];

          if (Yii::$app->request->isPost) {

          $this->setParam($config, $error);

          if ($error) {
          $result['success'] = false;
          $result['message'] = $error;
          return $result;
          }

          $result['success'] = true;
          $result['order'] = $this->execSell($config);
          if (isset($result['order']['msg'])) {
          $result['success'] = false;
          $result['message'][] = $result['order']['msg'];
          }
          return $result;
          } else {
          $result['success'] = false;
          $result['message'][] = 'Нет данных';
          return $result;
          }
         * 
         */
    }

    /*
      private function setParam(&$config, &$error) {

      $symbol = Yii::$app->request->post('symbol', '');
      if ($symbol) {
      $config['symbol'] = $symbol;
      } else {
      $error[] = 'Не указаны валюты';
      }

      $price = (float) Yii::$app->request->post('price', 0);
      if ($price) {
      $config['price'] = $price;
      }

      $quantity = (float) Yii::$app->request->post('quantity', 0);
      if ($quantity) {
      $config['quantity'] = $quantity;
      } else {
      $error[] = 'не указано количество';
      }

      $type = Yii::$app->request->post('type', 'LIMIT'); //MARKET
      if ($type == 'MARKET') {
      $config['type'] = 'MARKET';
      $config['price'] = 0;
      } else {
      $config['type'] = 'LIMIT';
      }

      $stopPrice = Yii::$app->request->post('stopPrice', false);
      if ($stopPrice) {
      $config['flags']['stopPrice'] = $stopPrice;
      }
      }
     * 
     */
    /*
      private function execBuy($config) {

      $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);
      $keys = $this->getKey($user_marketplace_id);

      $api = new Api($keys['key'], $keys['secret']);

      ob_start();
      $order = $api->buy($config['symbol'], $config['quantity'], $config['price'], $config['type'], $config['flags']);
      ob_end_clean();

      return $order;
      }

      private function execSell($config) {

      $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);
      $keys = $this->getKey($user_marketplace_id);

      $api = new Api($keys['key'], $keys['secret']);

      ob_start();
      $order = $api->sell($config['symbol'], $config['quantity'], $config['price'], $config['type'], $config['flags']);
      ob_end_clean();

      return $order;
      }

      private function getKey($user_marketplace_id) {

      $user_id = Yii::$app->user->getId();
      $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();

      if ($UserMarketplace) {
      return array(
      'key' => $UserMarketplace['key'],
      'secret' => $UserMarketplace['secret']
      );
      } else {
      return false;
      /* array(
      'key' => false,
      'secret' => false
      ); * /
      }
      }
     * 
     */

    public function actionAccount() {

        $this->view->registerJsFile('/js/flotr2/flotr2.js', ['depends' => ['yii\web\JqueryAsset']]);
        $this->view->registerJsFile('/js/trade.js', ['depends' => ['yii\web\JqueryAsset']]);

        $data = [];

        $user_id = Yii::$app->user->getId();
        $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);

        // надо проверить подключение....
        
        $data['user_marketplace_id'] = $user_marketplace_id;

        $data['currency'] = $this->htmlStatusBar();

        $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();
        $api = $this->getClassApi($UserMarketplace['marketplace_id'], $UserMarketplace['key'], $UserMarketplace['secret']);
        
        $Marketplace = Marketplace::findOne(['marketplace_id' => $UserMarketplace['marketplace_id']])->toArray();
        
        $data['name'] = $UserMarketplace['name'];
        $data['tradingview_market_name'] = strtoupper($Marketplace['marketplace_class']);
            
        $symbols = $api->getSymbols();
        $names = array_column($symbols, 'name');
        array_multisort($symbols, SORT_ASC, $names);
        
        $data['symbols'] = $symbols;

        $data['menu'] = UserMenu::get();

        $data["urlBuy"] = Url::to(['usermp/buy', 'user_marketplace_id' => $user_marketplace_id]);
        $data["urlSell"] = Url::to(['usermp/sell', 'user_marketplace_id' => $user_marketplace_id]);


        return $this->render('trade', $data);
        /*
          exit;

          // подключаем js


          $user_id = Yii::$app->user->getId();
          $data = [];
          $data['menu'] = UserMenu::get();
          $user_marketplace_id = Yii::$app->request->get('user_marketplace_id', 0);
          $UserMarketplace = UserMarketplace::findOne(['user_marketplace_id' => $user_marketplace_id, 'user_id' => $user_id])->toArray();
          $Marketplace = Marketplace::findOne(['marketplace_id' => $UserMarketplace['marketplace_id']])->toArray();

          $data['state'] = \app\models\ApiMarketplace::getState($UserMarketplace['marketplace_id'], $UserMarketplace['key'], $UserMarketplace['secret']);

          $api = new Api($UserMarketplace['key'], $UserMarketplace['secret']);

          $ticks = $api->candlesticks("BNBBTC", "1m");

          $server = $api->time();

          var_dump($server);
          echo "\n";
          var_dump(microtime());
          echo "\n";
          echo "api " . date("d.m.Y H:i:s", (int) ($server['serverTime'] / 1000)) . "\n";
          echo "server: " . time() . "\n";
          echo date("d.m.Y H:i:s", time()) . "\n";

          foreach ($ticks as $key => &$t) {
          $t['op'] = date("d.m.Y H:i:s", (int) ($t['openTime'] / 1000));
          $t['ct'] = date("d.m.Y H:i:s", (int) ($t['closeTime'] / 1000));
          $t['key'] = date("d.m.Y H:i:s", (int) ($key / 1000));
          }
          print_r($ticks);
          exit;
          //print_r($State);

          $data = array_merge($data, $this->userTasks());

          return $this->render('account', $data);
         * 
         */
    }

    private function htmlStatusBar() {
        $data = [];
        //  $data['menu'] = $this->menu();
        //$marketplace_id = Yii::$app->request->get('marketplace_id', 0);
        //$data['marketplace_id'] = $marketplace_id;
        $data['currency'] = [];
        $records = Currency::find()->all();

        foreach ($records as $record) {
            $data['currency'][$record['currency_code']] = [
                'currency_code' => $record['currency_code'],
                'name' => $record['currency_name']
            ];
        }

        //echo Yii::$app->getPathOfAlias('application.views.site.audit') . '.php';
        //exit;
        return $data['currency'];

        //return $this->render('statusbar', $data);
    }

    private function userTasks() {
        $data = array();

        $records = Currency::find()->where("main='0'")->all();

        foreach ($records as $record) {
            $data['currency'][$record['currency_code']] = [
                'currency_code' => $record['currency_code'],
                'name' => $record['currency_name']
            ];
        }



        /// по хорошему надо форму оформить
        $data['formActionTaskAdd'] = Url::to(['usermp/taskadd']);
        return $data;
    }

    public function actionTaskadd() {
        if (Yii::app()->request->isPostRequest) {

            $UserTask = new UserTask;

            $UserTask->user_id = Yii::$app->user->getId();
            $name = Yii::$app->request->post('task', 'buy');
            $name = Yii::$app->request->post('task', 'buy');
        }
    }

}
