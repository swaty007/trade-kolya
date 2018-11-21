<?php

/**
 * Returns the ticker for all markets.
 */

require_once("../../vendor/autoload.php");

use poloniex\api\PoloniexAPIPublic;
use poloniex\api\Poloniex;

// Static call
//$ticket = PoloniexAPIPublic::returnTicker();
//var_dump($ticket);

// Dynamic call
$poloniex = new Poloniex();
//$ticket = $poloniex->returnTicker();
$ticket = $poloniex->returnChartData('USDT_BTC', 300, time()-24*60*60, time());
var_dump($ticket);
