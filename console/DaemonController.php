<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace console\controllers;
 
use Yii;
use yii\helpers\Url;
use yii\console\Controller;
use frontend\models\Twixxr;
 
/**
 * Test controller
 */
class DaemonController extends Controller {
 
    public function actionIndex() {
        echo "Yes, cron service is running.";
    }
 
    public function actionFrequent() {
      // called every two minutes
      // */2 * * * * ~/sites/www/yii2/yii test
      $time_start = microtime(true);
      $x = new \frontend\models\Twixxr();
      $x->process($time_start);
      $time_end = microtime(true);
      echo 'Processing for '.($time_end-$time_start).' seconds';
    }
 
    public function actionQuarter() {
        // called every fifteen minutes
        $x = new \frontend\models\Twixxr();
        $x->loadProfiles();
      }
 
      public function actionHourly() {
        // every hour
        $current_hour = date('G');
        if ($current_hour%4) {
          // every four hours
        }
            if ($current_hour%6) {
            // every six hours
          }
        }
}