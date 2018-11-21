<?php

namespace app\models;

use Yii;
use yii\base\Model;

use app\models\Marketplace;
use app\models\UserMarketplace;
use yii\widgets\Menu;
use yii\helpers\Url;

/**
 * ContactForm is the model behind the contact form.
 */
class ApiMarketplace extends Model
{

    /**
     * @return array customized attribute labels
     */
    public static function getState($marketplace_id, $key, $secret)
    {
        $api = null;
       switch ($marketplace_id){
           case 1:
               $api = new api\Binance($key, $secret);               
               break;
       }
       
       if (!$api){
           return false;
       }
       
       return $api->getState();
    }

}
