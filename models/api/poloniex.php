<?php

namespace app\models\api;

//include_once __DIR__ . '/../../components/Poloniex/src/Poloniex.php';
//include_once __DIR__ . '/../../components/Poloniex/vendor/autoload.php';

include_once __DIR__ . '/../../components/Poloniex/src/tools/Request.php';
include_once __DIR__ . '/../../components/Poloniex/src/PoloniexAPIConf.php';
include_once __DIR__ . '/../../components/Poloniex/src/PoloniexAPIPublic.php';
include_once __DIR__ . '/../../components/Poloniex/src/PoloniexAPITrading.php';
include_once __DIR__ . '/../../components/Poloniex/src/Poloniex.php';

//require_once("../../vendor/autoload.php");


use poloniex\api\Poloniex as ApiPoloniex;
use poloniex\api\PoloniexAPIPublic;
use poloniex\api\PoloniexAPIConf;
use poloniex\api\PoloniexAPITrading;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//use app\components\Poloniex\Poloniex;

class Poloniex extends exchange {

    private function symbolFormat($symbol) {
        $num = func_num_args();
        
        $symbols = array();                
        for($i=0; $i<$num && $i<2; $i++){
            $symbols[] = func_get_arg($i);
        }
        
        return join('_', $symbols);
        
        //return $symbol;
        /*
          $symbols = explode('_', $symbol);

          return join('_', $symbols);
         * 
         */
    }
    
    public function getExchangeSymbol($symbol1, $symbol2){
        return $this->symbolFormat($symbol1, $symbol2);
    }

    public function getSymbols() {

        $api = new ApiPoloniex($this->key, $this->secret);
        $ticker = $api->returnTicker();

        //print_r($ticker); exit;

        //$symbols = array_keys($ticker);
        $result = array();
        foreach ($ticker as $key => $value) {
            $result[] = array(
                'name' => $key,
                'tradingview' => join('', array_reverse(explode('_', $key)))
            );
        }
        //print_r($symbols); exit;

        return $result;
    }

    public function getTicks($symbol, $config) {

        $symbol = $this->symbolFormat($symbol);

        $api = new ApiPoloniex($this->key, $this->secret);
        $ticks = $api->returnChartData($symbol, 300, time() - 24 * 60 * 60, time());

        //print_r($ticks); exit;

        $data = [];
        //$count = 0;
        foreach ($ticks as $value) {
            $data[] = array(
                $value['date'], // unixTimestamp времени
                //$count,
                (float) $value['open'], // курс на открытие торгов                
                (float) $value['high'], // курс максимальный
                (float) $value['low'], // курс минимальный
                (float) $value['close'], // цена на закрытие торгов
            );
        }

        return $data;
    }

    // завершенные ордера пользователя
    public function getOrders($symbol) {
        
    }

    // открытые ордера пользователя
    public function getOpenorders($symbol) {
        
    }

    // добавляет ордер
    public function addOrder($symbol, $config) {
        
    }

    // отменяет ордер пользователя
    public function cancelOrder($symbol, $order_id) {
        
    }

    // баланс пользователя 
    public function getBalances($empty = false) {

        $api = new ApiPoloniex($this->key, $this->secret);
        $Balance = $api->returnBalances();

        $data = array();
        foreach ($Balance as $key => $value) {
            if (!$empty || $value > 0) {
                $data[$key] = array(
                    'available' => $value,
                    'onOrder' => 0,
                    'btcValue' => 0,
                    'btcTotal' => 0,
                );
            }
        }

        return $data;
        //print_r($Balance); exit;
    }
    
        public function getBalancesUSD() {

        $balances = $this->getBalances(true);

        $data = array();
        foreach ($balances as $symbol => $balance) {

            $data[$symbol] = $balance;
            $data[$symbol]['usd'] = $this->getValueUSD($balance['available'] + $balance['onOrder'], $symbol);
        }

        return $data;
    }
    
    public function get24h($symbol = null){
        
        $api = new ApiPoloniex($this->key, $this->secret);
        
        $ticker = $api->returnTicker();
        //print_r($ticker[$symbol]); exit;
        
        $data = array();
        if (isset($ticker[$symbol])){
            $result = $ticker[$symbol];
            $data['symbol'] = $symbol;
            $data['lastPrice'] = (float)$result['last']; // последняя цена
            $data['percentChange'] = (float)$result['percentChange']; // изменение цены за сутки в процентах
            $data['lowestAsk'] = (float)$result['lowestAsk']; //  Лучшая цена продажи
            $data['highestBid'] = (float)$result['highestBid']; // Лучшая цена покупки
            $data['baseVolume'] = (float)$result['baseVolume']; // Объем торгов в базовой валюте
            $data['quoteVolume'] = (float)$result['quoteVolume']; // Объем торгов в квотируемой валюте
            $data['high24hr'] = (float)$result['high24hr']; // последняя цена
            $data['low24hr'] = (float)$result['low24hr']; // последняя цена
            
        }
        
        return $data;
    }

    public function getValueUSD($value, $symbol) {
        static $rate = null;

        if (is_null($rate)) {
            $rate = $this->getRates();
        }

        $paire = $this->getExchangeSymbol($symbol, $this->getUSD());

        if (isset($rate[$paire])) {
            return $value * $rate[$paire];
        } else {
            return false;
        }
    }

    // Курсы валют текущие ()
    public function getRates(){
        
        $api = new ApiPoloniex($this->key, $this->secret);
        $Currencies = $ticker = $api->returnTicker();
        
        $data = array();
        foreach ($Currencies as $currency => $value) {
            $data[$currency] = $value['last'];
        }
        
        //print_r($data); exit;
        return $data;
        
    }

    // текущие предложения спрос по валютной паре
    // "стакан"
    public function getDepth($symbol) {
        $symbol = $this->symbolFormat($symbol);

        $api = new ApiPoloniex($this->key, $this->secret);
        $depth = $api->returnOrderBook($symbol, null);
        //print_r($depth); exit;

        $data = array();

        foreach ($depth as $key => $values) {
            if (!in_array($key, array('bids', 'asks'))) {
                continue;
            }

            //print_r($values); exit;
            foreach ($values as $value) {
                //print_r($value); exit;
                $data[$key][$value[0]] = $value[1];
            }
        }
        //print_r($data);exit;

        return $data;
    }

    // последние сделки по валютной паре (на бирже в целом)
    public function getTrades($symbol) {
        $symbol = $this->symbolFormat($symbol);

        $api = new ApiPoloniex($this->key, $this->secret);
        $History = $api->returnPublicLastTradeHistory($symbol, 3600);

        $data = array();
        foreach ($History as $value) {
            $data[] = array(
                'price' => $value['rate'],
                'quantity' => $value['amount'],
                'timestamp' => strtotime($value['date']),
                'maker' => $value['type'] == 'sell' ? 'true' : 'false',
            );
        }

        return $data;
        //print_r($data); exit;
    }

}
