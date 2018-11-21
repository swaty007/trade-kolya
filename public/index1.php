<?php
//phpinfo();

//API Key:
$key = '0ubnZxTBQeiregtOXf584sJZD37ytC3DwV7Tyar2TtZS8oai83vnOQX5YJ0DlOmE';
//Secret:
$Secret = '37j7rHQiGyciwQUlTGbH4QI5jB8QhgStYKy6kZbwQXufYckJYvMHW0Q1koZ4zSSv';


include_once __DIR__ . '/php-binance-api-master/php-binance-api.php';

$api = new Binance\API($key, $Secret);

$ticker = $api->prices();
print_r($ticker); // List prices of all symbols

exit;

$balances = $api->balances();
print_r($balances);