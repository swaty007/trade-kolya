<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use Yii\app;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Marketplace;
use app\models\CurrencyExchange;

use app\components\Binance\Api;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BinanceController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    
    const Marketplace = 'Binance';


    public function actionIndex()
    {
        //echo "Binance run!";
        //print_r(Yii::$app->params['marketplace'][self::Marketplace]);
        
        $Marketplace = Marketplace::find()->where(['marketplace_name' => self::Marketplace])->one();
        //$Marketplace->find()
        
        //print_r($Marketplace->attributes['marketplace_id']);
        $start = microtime(true);
        $prices = $this->getCourses();
        $time = microtime(true) - $start;
        echo "Time get data: {$time}\n";
        
        $date = time();
        
        $i = 0;
        $connection = Yii::$app->db;
        
        $start = microtime(true);
        $added = array();
        foreach ($prices as $symbol => $price) {
            
            $added[] = array(
                'marketplace_id' => $Marketplace->attributes['marketplace_id'],
                'symbol' => $symbol,
                'price' => $price,
                'date' => $date
            );
            $i++;
            /*
            $Course = new CurrencyExchange();
            $Course->marketplace_id = $Marketplace->attributes['marketplace_id'];
            $Course->symbol = $symbol;
            $Course->price = $price;
            $Course->date = $date;            
            if ($Course->save()){
                $i++;
            }
             * 
             */
            
        }
        
        $connection->createCommand()->batchInsert('currency_exchange',
                    ['marketplace_id', 'symbol', 'price', 'date'],
                    $added)
                    ->execute();
        
        echo 'Added: ' . $i . " records\n";
        $time = microtime(true) - $start;
        echo "Time add records: {$time}\n";
        
        $start = microtime(true);
        // удаляем записи старше недели
        $olddate = time() - 7 * 24 * 60 * 60;
        //$connection->createCommand()->delete('currency_exchange', 'date < :olddate AND marketplace_id = :marketplace_id', [':olddate' => $olddate, 'marketplace_id' => $Marketplace->attributes['marketplace_id']])->execute();
                
        $deleted = 0;
        $deleted = CurrencyExchange::deleteAll('date < :olddate AND marketplace_id = :marketplace_id', [':olddate' => $olddate, 'marketplace_id' => $Marketplace->attributes['marketplace_id']]);

        echo 'Deleted: ' . $deleted . " records\n";
        $time = microtime(true) - $start;
        echo "Time deleted records: {$time}\n";
        
        return ExitCode::OK;
    }
    
    private function getCourses(){
        
        $keys = Yii::$app->params['marketplace'][self::Marketplace];
        $api  = new Api($keys['key'], $keys['secret']);
        
        return $api->prices();
    }
}
