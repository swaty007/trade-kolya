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
class UserMenu extends Model
{

    /**
     * @param null $user_id
     * @return string customized attribute labels
     * @throws \Exception
     */
    public static function get($user_id = null)
    {
        //$marketplace = new Marketplace();
        $records = Marketplace::find()->all();
        $user_id = Yii::$app->user->getId();
        
        $UserMarketplace = UserMarketplace::find()
                    ->where(['user_id' => $user_id])
                ->orderBy('order')
                ->asArray()
                ->all();
        
        $user_marketplace = [];
        foreach ($UserMarketplace as $marketplace) {
            $user_marketplace[] = [
              'label' => $marketplace['name'],
                'url' => Url::to(['usermp/account', 'user_marketplace_id' => $marketplace['user_marketplace_id']])
            ];
        }
        /*
        $menu_marketplace = [];
        foreach ($records as $record){
            $menu_marketplace[] = [
              'label' => $record['marketplace_name'],
                'url' => Url::to(['cabinet/marketplace', 'marketplace_id' => $record['marketplace_id']])
            ];
        }
         * 
         */

        $menu = [
            'items' => [
                /*
                ['label' => 'Биржи', 'url' => '#', 
                        'items' => $menu_marketplace
                    ],
                 * 
                 */
                ['label' => 'Мои аккаунты', 'url' => Url::to(['cabinet/accounts']),
                    'items' => $user_marketplace
                ],
                ['label' => 'Настройки', 'url' => ['#']],
                ['label' => 'Личные данные', 'url' => ['#']],
            ],
            'options' => [
                'id' => 'navid',
                'class' => 'navbar navbar-default left_menu',
                //'style' => '',
                'data' => 'menu',
            ],
            'labelTemplate' => '{label} Label',
            'linkTemplate' => '<a href="{url}"><span>{label}</span></a>',
            'activeCssClass' => 'active',
            'firstItemCssClass' => 'fist',
            'lastItemCssClass' => 'last',
        ];

        return Menu::widget($menu);
    }

}
