<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\api;

/**
 *
 * @author Дмитрий
 */


abstract class exchange {
    //put your code here
    
    protected $key = null;
    protected $secret = null;
    public $error = [];
    
    public function __construct($key = null, $secret = null) {
         // initialization code
        $this->key = $key ? $key : null;
        $this->secret = $secret ? $secret : null;
        
        //echo $this->key;
        //exit;
    }
    
    public function setKey($key){
        $this->key = $key;
    }
    
    public function setSecret($secret){
        $this->secret = $secret;
    }
    
    abstract public function getSymbols();
    
    /*
     * Вернет данные для графика
     * @param string $symbol валютная пара
     * @param array $config настройки запроса
     * @return array array([openTime, // время
     * (float) open, // курс на открытие торгов
     * (float) high, // курс максимальный
     * (float) low, // курс минимальный
     * (float) close] // цена на закрытие торгов
     * []
     * );
     */
    abstract public function getTicks($symbol, $config);

    // завершенные ордера пользователя
    abstract public function getOrders($symbol);
    
    // открытые ордера пользователя
    abstract public function getOpenorders($symbol);
    
    // добавляет ордер
    abstract public function addOrder($symbol, $config);
    
    // отменяет ордер пользователя
    abstract public function cancelOrder($symbol, $order_id);
    
    // баланс пользователя 
    abstract public function getBalances();
    
    // текущие предложения спрос по валютной паре
    // "стакан"
    abstract public function getDepth($symbol);
    
    // последние сделки по валютной паре (на бирже в целом)
    abstract public function getTrades($symbol);
    
}
