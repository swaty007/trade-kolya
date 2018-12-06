<?php

namespace app\widgets;

use app\models\Notifications;
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
class NotificationWidget extends Widget
{

    public $menu = [];

    public function run()
    {

        $id = Yii::$app->user->getId();
        $query = Notifications::find()->where(['user_id'=>$id])->andWhere(['show' => 0]);
        $notification_count = clone $query;
        $notification_count = $notification_count->count();
        $notification_items = '';
        foreach ($query->limit(5)->orderBy('time DESC')->all() as $notification_item) {
            $status_class = '';
            $status_fa = '';
            switch ($notification_item->status){
                case 'success':
                    $status_class = "alert-success";
                    $status_fa = "fa-check-square";
                    break;
                case 'error':
                    $status_class = "alert-danger";
                    $status_fa = "window-close";
                    break;
                case 'notification':
                    $status_class = "alert-warning";
                    $status_fa = "fa-exclamation-circle";
                    break;
                case 'info':
                    $status_class = "alert-info";
                    $status_fa = "fa-info-circle";
                    break;
            }

            $notification_items.= '<li class="'.$status_class.' notification-item" data-id="'.$notification_item->id.'">
                                        <a>
                                            <div class="notification-wrap">
                                                <i class="fa '.$status_fa.' fa-fw"></i><span>'.$notification_item->message.'</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>';
        }

       echo '<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <i class="fa fa-bell"></i>  <span class="label label-primary">'.$notification_count.'</span>
                                </a>
                                <ul id="notification_wrap" class="dropdown-menu dropdown-alerts animated fadeInRight">'.$notification_items.
           '<li>
                                        <div class="text-center link-block">
                                            <a href="'.Url::to(['user/notifications']).'">
                                                <strong>Просмотреть все уведомления</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>';

    }
}
