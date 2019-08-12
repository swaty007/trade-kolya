<?php

namespace app\widgets;

use app\models\User;
use Yii;
use app\models\UserMarketplace;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\bootstrap\Widget;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class MainMenu extends Widget
{

    public $menu = [];

    public function run()
    {

        $this->menu[] = array(
            'label' => 'TAKE',
            'class' => Url::to(['cabinet/index']),
            'template' => '<div class="dropdown profile-element"><a href="{url}">                             
                                <img alt="image" class="user-icon" src="../image/logo6.png" />      
                            </a></div>
                            <div class="logo-element">
                                 <a href="{url}"><img alt="image" class="user-icon" src="../image/logo4.png" /></a>
                            </div>',
            'url' => Url::to(['cabinet/index']),

        );

        $user_id = Yii::$app->user->getId();

        $check = UserMarketplace::find()->where(['user_id' => $user_id])->asArray()->all();

        $subMenu = array();

        if (!empty($check)) {
            $user_marketplace = UserMarketplace::find()
                ->select(['user_marketplace_id', 'name', 'marketplace_name'])
                ->innerJoin('marketplace', 'marketplace.marketplace_id = user_marketplace.marketplace_id')
                ->where(['user_id' => $user_id])
                ->where(['!=', 'user_market_id', 0])
                ->orderBy('order')
                ->asArray()
                ->all();

            foreach ($user_marketplace as $value) {
                $subMenu[] = array(
                    'label' => $value['name'],
                    'url' => Url::to(['usermp/account', 'user_marketplace_id' => $value['user_marketplace_id']])
                );
            }
        }


        $subMenu[] = array(
            'label' => 'Мои биржи',
            'url' => Url::to(['cabinet/accounts']),
            'template' => '<a href="{url}" class="main-li">{label}</a>',
        );

        if( !in_array(Yii::$app->user->identity->user_role, ['user','client-ad']) ) {
            $this->menu[] = array(
                'label' => 'Трейдинг',
                'class' => 'fa-area-chart',
                'template' => '<a href="{url}"><i class="fa fa-tasks"></i> <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                'url' => Url::to(['cabinet/accounts']),
                'active' => Yii::$app->controller->module->requestedRoute == '',
                'items' => $subMenu
            );
        }


        $this->menu[] = array(
            'label' => 'Статистика',
            'class' => 'fa-area-chart',
            'template' => '<a href="{url}"><i class="fa fa-area-chart"></i> <span class="nav-label">{label}</span></a>',
            'url' => Url::to(['usermp/stat']),
            'active' => Yii::$app->controller->module->requestedRoute == 'usermp/stat'
        );

//        $this->menu[] = array(
//            'label' => 'Лучшие трейдеры',
//            'class' => 'fa-users',
//            'template' => '<a href="{url}"><i class="fa fa-users"></i> <span class="nav-label">{label}</span></a>',
//            'url' => Url::to(['trader/top']),
//            'active' => Yii::$app->controller->module->requestedRoute == 'trader/top'
//        );

//        $this->menu[] = array(
//            'label' => 'Сигналы трейдеров',
//            'class' => 'fa-bullhorn',
//            'template' => '<a href="{url}"><i class="fa fa-bullhorn"></i> <span class="nav-label">{label}</span></a>',
//            'url' => Url::to(['trader/top'])
//        );

        $this->menu[] = array(
            'label' => 'Информер',
            'class' => 'fa-newspaper-o',
            'template' => '<a href="{url}"><i class="fa fa-newspaper-o"></i><span class="nav-label">{label}</span></a>',
            'active' => Yii::$app->controller->module->requestedRoute == 'informer/index',
            'url' => Url::to(['informer/index'])
        );

        $this->menu[] = array(
            'label' => 'Инвестпул',
            'class' => 'fa-info-circle',
            'template' => '<a href="{url}"><i class="fa fa-database"></i> <span class="nav-label">{label}</span></a>',
            'active' => Yii::$app->controller->module->requestedRoute == 'pool/index',
            'url' => Url::to(['pool/index'])
        );

        if( !in_array(Yii::$app->user->identity->user_role, ['user','client-ad']) ) {
            $this->menu[] = array(
                'label' => 'Магазин',
                'class' => 'fa-info-circle',
                'template' => '<a href="{url}"><i class="fa fa-shopping-cart"></i> <span class="nav-label">{label}</span></a>',
                'active' => Yii::$app->controller->module->requestedRoute == 'market/index',
                'url' => Url::to(['market/index'])
            );
        }

        $this->menu[] = array(
            'label' => 'Копирование',
            'class' => 'fa-info-circle',
            'template' => '<a href="{url}"><i class="fa fa-copy"></i> <span class="nav-label">{label}</span></a>',
            'active' => Yii::$app->controller->module->requestedRoute == 'cabinet/copy-index',
            'url' => Url::to(['cabinet/copy-index'])
        );

        $this->menu[] = array(
            'label' => 'Транзакции',
            'class' => 'fa-info-circle',
            'template' => '<a href="{url}"><i class="fa fa-money"></i> <span class="nav-label">{label}</span></a>',
            'active' => Yii::$app->controller->module->requestedRoute == 'coins/transactions',
            'url' => Url::to(['coins/transactions'])
        );

//        if( !in_array(Yii::$app->user->identity->user_role, ['user','client-trader']) ) {
            $this->menu[] = array(
                'label' => 'Рефералы',
                'class' => 'fa-info-circle',
                'template' => '<a href="{url}"><i class="fa fa-registered"></i> <span class="nav-label">{label}</span></a>',
                'active' => Yii::$app->controller->module->requestedRoute == 'referral/index',
                'url' => Url::to(['referral/index'])
            );
//        }

        if (User::canAdmin()) {

            $this->menu[] = array(
                'label' => 'Админка',
                'class' => 'fa-info-circle',
                'template' => '<a href="{url}"><i class="fa fa-gear"></i> <span class="nav-label">{label}</span></a>',
                'active' => Yii::$app->controller->module->requestedRoute == 'admin/index',
                'url' => Url::to(['admin/index'])
            );
        }

        $this->menu[] = array(
            'label' => 'FAQ',
            'class' => 'fa-question-circle',
            'template' => '<a href="{url}"><i class="fa fa-gear"></i> <span class="nav-label">{label}</span></a>',
            'active' => Yii::$app->controller->module->requestedRoute == 'cabinet/faq',
            'url' => Url::to(['cabinet/faq'])
        );

        echo Menu::widget([
            'items' => $this->menu,
            'options' => [
                'id' => 'side-menu',
                'class' => 'nav'
            ],
            'firstItemCssClass' => 'nav-header',

            'submenuTemplate' => "\n<ul class='nav nav-second-level collapse in' aria-expanded='true' role='menu'>\n{items}\n</ul>\n",]);
    }
}
