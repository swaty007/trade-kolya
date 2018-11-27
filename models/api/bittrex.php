<?php

namespace app\models\api;

////include __DIR__ . '/../../components/Bittrex/src/BittrexManager.php';
//use codenixsv\Bittrex\BittrexManager;

include __DIR__ . '/../../components/Bittrex-edsonmedina/src/edsonmedina/bittrex/Client.php';

use edsonmedina\bittrex\Client;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//use app\components\Poloniex\Poloniex;

class Bittrex extends exchange {

    public function symbolFormat() {
        $num = func_num_args();

        $symbols = array();
        for ($i = 0; $i < $num && $i < 2; $i++) {
            $symbols[] = func_get_arg($i);
        }

        return join('-', $symbols);
        /*
          $symbols = explode('_', $symbol);

          return join('_', $symbols);
         * 
         */
    }

    public function getExchangeSymbol($symbol1, $symbol2) {
        return $this->symbolFormat($symbol2, $symbol1);
    }
    
    public function getUSD() {
        return 'USDT';
    }

    private function getApi() {

        //$manager = new BittrexManager($this->key, $this->secret);
        //$api = $manager->createClient();

        $api = new Client($this->key, $this->secret);

        return $api;
    }

    public function getSymbols() {

        $api = $this->getApi();

        $Currencies = $api->getMarkets();

        //print_r($Currencies); exit;

        $data = array();
        foreach ($Currencies as $currency) {
            $data[] = array(
                'name' => $currency->MarketName,
                'tradingview' => join('', array_reverse(explode('-', $currency->MarketName)))
            );
        }

        return $data;
    }

    public function getTicks($symbol, $config) {

        $symbol = $this->symbolFormat($symbol);

        $api = $this->getApi();


        $ticks = $api->GetTicks($symbol); //$api->returnChartData($symbol, 300, time()-24*60*60, time());
        //print_r($ticks); exit;

        $data = [];
        //$count = 0;
        foreach ($ticks as $value) {
            $data[] = array(
                strtotime($value->T), // unixTimestamp времени
                //$count,
                (float) $value->O, // курс на открытие торгов                
                (float) $value->H, // курс максимальный
                (float) $value->L, // курс минимальный
                (float) $value->C, // цена на закрытие торгов
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


        $api = $this->getApi();
        $Balance = $api->getBalances();
        
        //print_r($Balance); exit;
        
        $data = array();
        foreach ($Balance as $key => $value) {
            if (!$empty || $value->Balance > 0) {
                $data[$value->Currency] = array(
                    'available' => (float) $value->Balance,
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
            //print_r($balance);
            //exit;
            $data[$symbol] = $balance;
            $data[$symbol]['usd'] = $this->getValueUSD($balance['available'] + $balance['onOrder'], $symbol);
        }
        
        //print_r($data);  exit;

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
            return 0;
        }
    }

    public function get24h($symbol = null) {

        $api = $this->getApi();


        $ticker = $api->getMarketSummary($symbol);

        //print_r($ticker); exit;

        $data = array();
        if (isset($ticker[0])) {
            $result = $ticker[0];
            $data['symbol'] = $result->MarketName;
            $data['lastPrice'] = (float) $result->Last; // последняя цена
            $data['percentChange'] = (float) $result->PrevDay; // $result['percentChange']; // изменение цены за сутки в процентах
            $data['lowestAsk'] = (float) $result->Ask; //$result['lowestAsk']; //  Лучшая цена продажи
            $data['highestBid'] = (float) $result->Bid; //$result['highestBid']; // Лучшая цена покупки
            $data['baseVolume'] = (float) $result->BaseVolume; //$result['baseVolume']; // Объем торгов в базовой валюте
            $data['quoteVolume'] = (float) $result->Volume; //$result['quoteVolume']; // Объем торгов в квотируемой валюте
            $data['high24hr'] = (float) $result->High; //$result['high24hr']; // последняя цена
            $data['low24hr'] = (float) $result->Low; //$result['low24hr']; // последняя цена
        }

        return $data;
    }

    // Курсы валют текущие ()
    public function getRates() {

        $api = $this->getApi();
        $Currencies = $api->getMarketSummaries();
        
        $data = array();
        foreach ($Currencies as $value) {
            $data[$value->MarketName] = $value->Last;
        }
        
        return $data;
    }

    // текущие предложения спрос по валютной паре
    // "стакан"
    public function getDepth($symbol) {
        $symbol = $this->symbolFormat($symbol);

        $api = $this->getApi();


        $depth = $api->getOrderBook($symbol, 'both');
        //print_r($depth); //exit;

        $data = array();

        foreach ($depth->sell as $value) {
            $data['asks'][(string) $value->Rate] = $value->Quantity;
        }
        foreach ($depth->buy as $value) {
            $data['bids'][(string) $value->Rate] = $value->Quantity;
        }
        //print_r($data); exit;
        return $data;
    }

    // последние сделки по валютной паре (на бирже в целом)
    public function getTrades($symbol) {
        $symbol = $this->symbolFormat($symbol);

        $api = $this->getApi();

        $History = $api->getMarketHistory($symbol);

        //print_r($History); exit;

        $data = array();
        foreach ($History as $value) {
            $data[] = array(
                'price' => $value->Price,
                'quantity' => $value->Quantity,
                'timestamp' => strtotime($value->TimeStamp) * 1000,
                'maker' => $value->OrderType == 'SELL' ? 'true' : 'false',
            );
        }

        return $data;
        //print_r($data); exit;
    }

}
