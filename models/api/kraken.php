<?php

namespace app\models\api;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once __DIR__ . '/../../components/Kraken/php/KrakenAPIClient.php';

class Kraken extends exchange {

    private function symbolFormat() {
        $num = func_num_args();
        
        $symbols = array();                
        for($i=0; $i<$num && $i<2; $i++){
            $symbols[] = func_get_arg($i);
        }
        return join('_', $symbols);

        //$symbols = explode('_', $symbol);
        //return join('', $symbols);
    }

    public function getExchangeSymbol($symbol1, $symbol2) {
        return $this->symbolFormat($symbol1, $symbol2);
    }

    public function getSymbols() {

        $api = $this->getApi();

        $ticker = $api->QueryPublic('AssetPairs');

        //print_r($ticker); exit;

        //$symbols = array_keys($ticker['result']);
        $result = array();
        foreach ($ticker['result'] as $key => $value) {
            $result[] = array(
                'name' => $key,
                'tradingview' => $key
            );
        }
        

        //print_r($symbols); exit;

        return $result;
    }

    private function getApi() {

        $beta = false;
        $url = $beta ? 'https://api.beta.kraken.com' : 'https://api.kraken.com';
        $sslverify = false; //$beta ? false : true;
        $version = 0;

        $api = new \Payward\KrakenAPI($this->key, $this->secret, $url, $version, $sslverify);

        return $api;
    }

    public function getTicks($symbol, $config) {


        //var_dump($this->key); exit;
        $symbol = $this->symbolFormat($symbol);


        $api = $this->getApi();

        //$res = $api->QueryPublic('Asset', array('pair' => 'XXBTZUSD'));
        //$res = $api->QueryPublic('AssetPairs');
        //print_r($res);

        $interval = isset($config['interval']) ? $config['interval'] : '1';

        $ticks = $api->QueryPublic('OHLC', array('pair' => $symbol, 'interval' => $interval));
        $data = [];
        foreach ($ticks['result'][$symbol] as $value) {
            $data[] = array(
                $value[0], // unixTimestamp времени
                //$count,
                (float) $value[1], // курс на открытие торгов                
                (float) $value[2], // курс максимальный
                (float) $value[3], // курс минимальный
                (float) $value[4], // цена на закрытие торгов
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
    public function getBalances($empty = false, $usd = false) {

        $api = $this->getApi();

        $query = $api->QueryPrivate('Balance');

        $balance = $query['result'];

        return $balance;
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
    
    public function get24h($symbol = null){
        
        $api = $this->getApi();
        
        $ticker = $api->QueryPublic('Ticker', ['pair' => $symbol]);
        
        $data = array();
        if (isset($ticker['result'][$symbol])){
            $result = $ticker['result'][$symbol];
            $data['symbol'] = $symbol;
            $data['lastPrice'] = (float)$result['c'][0]; // последняя цена
            $data['percentChange'] = '-'; // изменение цены за сутки в процентах
            $data['lowestAsk'] = (float)$result['a'][0]; //  Лучшая цена продажи
            $data['highestBid'] = (float)$result['b'][0]; // Лучшая цена покупки
            $data['baseVolume'] = (float)$result['v'][1]; // Объем торгов в базовой валюте
            $data['quoteVolume'] = (float)$result['p'][1]; // Объем торгов в квотируемой валюте
            $data['high24hr'] = (float)$result['l'][1]; // последняя цена
            $data['low24hr'] = (float)$result['h'][1]; // последняя цена
            
        }
        
        return $data;
    }

    // Курсы валют текущие ()
    public function getRates() {

        $api = $this->getApi();

        $ticker = $api->QueryPublic('Ticker');

        print_r($ticker);
        exit;
        return $ticker;
    }

    // текущие предложения спрос по валютной паре
    // "стакан"
    public function getDepth($symbol) {
        $symbol = $this->symbolFormat($symbol);

        $api = $this->getApi();

        $depth = $api->QueryPublic('Depth', array('pair' => $symbol));

        $data = array();
        foreach ($depth['result'][$symbol]['asks'] as $value) {
            $data['asks'][$value[0]] = $value[1];
        }
        foreach ($depth['result'][$symbol]['bids'] as $value) {
            $data['bids'][$value[0]] = $value[1];
        }
        //print_r($data); exit;
        return $data;
    }

    // последние сделки по валютной паре (на бирже в целом)
    public function getTrades($symbol) {
        $symbol = $this->symbolFormat($symbol);

        $api = $this->getApi();

        $Trades = $api->QueryPublic('Trades', array('pair' => $symbol));

        $data = array();
        foreach ($Trades['result'][$symbol] as $value) {
            $data[] = array(
                'price' => $value[0],
                'quantity' => $value[1],
                'timestamp' => (int) ($value[2] * 1000),
                'maker' => $value[3] == 's' ? 'true' : 'false',
            );
        }

        return $data;
    }

}
