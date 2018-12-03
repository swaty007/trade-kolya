<?php

namespace app\models\api;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\components\Binance\Api;

class Binance extends exchange {

    private function symbolFormat() {
        $num = func_num_args();

        $symbols = array();
        for ($i = 0; $i < $num && $i < 2; $i++) {
            $symbols[] = func_get_arg($i);
        }

        return join('', $symbols);
        /*
          $symbols = explode('_', $symbol);

          return join('', $symbols);
         * 
         */
    }

    public function symbolExplode($symbol) {

        if (!isset($_SESSION['api']['binance']['symbolExplode'])) {
            $api = new Api($this->key, $this->secret);
            $symbols = array_keys($api->prices());
            //print_r($symbols); exit;
            $currencies = array_keys($this->getBalances());

            $result = array();
            foreach ($currencies as $l) {
                foreach ($currencies as $r) {
                    if (in_array($l . $r, $symbols)) {
                        $result[$l . $r] = array(
                            'left' => $l,
                            'right' => $r
                        );
                    }
                }
            }
            $_SESSION['api']['binance']['symbolExplode'] = $result; // пока так.
        } else {
            $result = $_SESSION['api']['binance']['symbolExplode'];
        }

        if (isset($result[$symbol])) {
            return array($result[$symbol]['left'], $result[$symbol]['right']);
        } else {
            return false;
        }
    }

    public function getExchangeSymbol($from, $to) {
        return $this->symbolFormat($from, $to);
    }

    public function getSymbols() {
        $api = new Api($this->key, $this->secret);
        $ticker = $api->prices();

        $symbols = array_keys($ticker);

        $result = array();
        foreach ($ticker as $key => $value) {
            $result[] = array(
                'name' => $key,
                'tradingview' => $key
            );
        }

        //print_r($symbols); exit;

        return $result;
    }

    public function getUSD() {
        return 'USDT';
    }

    public function getTicks($symbol, $config) {
        //var_dump($this->key); exit;
        $symbol = $this->symbolFormat($symbol);

        $api = new Api($this->key, $this->secret);

        $time = isset($config['time']) ? $config['time'] : '1m';
        $ticks = $api->candlesticks($symbol, $time);

        $data = [];
        //$count = 0;
        foreach ($ticks as $value) {
            $data[] = array(
                $value['openTime'], // unixTimestamp времени
                //$count,
                (float) $value['open'], // курс на открытие торгов                
                (float) $value['high'], // курс максимальный
                (float) $value['low'], // курс минимальный
                (float) $value['close'], // цена на закрытие торгов
            );
            //$count++;
            //if ($count > 50) {
            //break;
            //}
        }

        return $data;
    }

    // завершенные ордера пользователя
    public function getOrders($symbol) {

        $api = new Api($this->key, $this->secret);

        $api->useServerTime();
        $result = $api->orders($symbol);

        return $result;
    }

    // открытые ордера пользователя
    public function getOpenorders($symbol) {
        $api = new Api($this->key, $this->secret);

        $api->useServerTime();
        $result = $api->openOrders($symbol);

        return $result;
    }

    // добавляет ордер
    public function addOrder($symbol, $config) {

        $api = new Api($this->key, $this->secret);

        ob_start();
        if ($config['action'] == 'buy') {
            $order = $api->buy($config['symbol'], $config['quantity'], $config['price'], $config['type'], $config['flags']);
        } elseif ($config['action'] == 'sell') {
            $order = $api->sell($config['symbol'], $config['quantity'], $config['price'], $config['type'], $config['flags']);
        }
        ob_end_clean();

        if ($api->error) {
            $this->error = reset($api->error);
            $order = false;
        }
        return $order;
    }

    // отменяет ордер пользователя
    public function cancelOrder($symbol, $order_id) {
        $api = new Api($this->key, $this->secret);

        $api->useServerTime();
        $order = $api->cancel($symbol, $order_id);

        return $order;
    }

    // баланс пользователя // empty - убрать пустые
    public function getBalances($symbol = false, $empty = false) {

        $api = new Api($this->key, $this->secret);

        $api->useServerTime();
        $balance = $api->balances();

        if ($api->error) {
            $this->error = reset($api->error);
            return false;
        }
        //print_r($balance); //exit;
        if ($symbol) {
            $symbols = $this->symbolExplode($symbol);
        } else {
            $symbols = array();
        }

        $result = array();
        foreach ($balance as $key => $row) {
            if ($empty && $row['available'] <= 0 && $row['onOrder'] <= 0) {
                continue;
            }
            if ($symbols && ($key != $symbols[0] && $key != $symbols[1])) {
                continue;
            }
            $result[$key] = $row;

            /*
              if (!$empty || $row['available'] > 0 || $row['onOrder'] > 0) {
              if ($symbols && ($key == $symbols[0] || $key == $symbols[1])) {
              $result[$key] = $row;
              } elseif (!$symbols) {
              $result[$key] = $row;
              }
              }elseif ($symbols && ($key == $symbols[0] || $key == $symbols[1])) {
              $result[$key] = $row;
              } elseif (!$symbols) {
              $result[$key] = $row;
              }
             * 
             */
        }

        return $result;
    }

    public function getBalancesUSD() {

        $balances = $this->getBalances(false, true);

        $data = array();

        if ($balances) {
            foreach ($balances as $symbol => $balance) {

                $data[$symbol] = $balance;
                $data[$symbol]['usd'] = $this->getValueUSD($balance['available'] + $balance['onOrder'], $symbol);
            }
        }

        return $data;
    }

    public function get24h($symbol = null) {

        $api = new Api($this->key, $this->secret);

        $result = $api->prevDay($symbol);

        $data = array();
        if ($result) {
            $data['symbol'] = $result['symbol'];
            $data['lastPrice'] = $result['lastPrice']; // последняя цена
            $data['percentChange'] = $result['priceChangePercent']; // изменение цены за сутки в процентах
            $data['lowestAsk'] = $result['askPrice']; //  Лучшая цена продажи
            $data['highestBid'] = $result['bidPrice']; // Лучшая цена покупки
            $data['baseVolume'] = $result['volume']; // Объем торгов в базовой валюте
            $data['quoteVolume'] = $result['quoteVolume']; // Объем торгов в квотируемой валюте
            $data['high24hr'] = $result['highPrice']; // последняя цена
            $data['low24hr'] = $result['lowPrice']; // последняя цена
        }

        return $data;
    }

    public function getValueUSD($value, $symbol) {
        static $rate = null;

        if (is_null($rate)) {
            $rate = $this->getRates();
        }

        if ($symbol == $this->getUSD()) {
            return $value;
        }

        $paire = $this->getExchangeSymbol($symbol, $this->getUSD());

        if (isset($rate[$paire])) {
            return $value * $rate[$paire];
        } else {
            return false;
        }
    }

    // Курсы валют текущие ()
    public function getRates() {

        $api = new Api($this->key, $this->secret);
        $ticker = $api->prices();
        //print_r($ticker); exit;
        /*
         * Array
          (
          [ETHBTC] => 0.03455900
          [LTCBTC] => 0.00909900
          [BNBBTC] => 0.00152340 ....
          )
         */
        return $ticker;
    }

    // текущие предложения спрос по валютной паре
    // "стакан"
    public function getDepth($symbol) {
        $symbol = $this->symbolFormat($symbol);

        $api = new Api($this->key, $this->secret);

        $depth = $api->depth($symbol);
        //print_r($depth); exit;
        return $depth;
    }

    // последние сделки по валютной паре (на бирже в целом)
    public function getTrades($symbol) {
        $symbol = $this->symbolFormat($symbol);

        $api = new Api($this->key, $this->secret);

        $trades = $api->aggTrades($symbol);
        $trades = array_reverse($trades);

        return $trades;
    }

}
