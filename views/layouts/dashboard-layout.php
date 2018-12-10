<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\widgets\MainMenu;
use yii\helpers\Url;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="mini-navbar">
        <?php $this->beginBody() ?>
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side new-navbar" role="navigation">
                <div class="sidebar-collapse">
                    <?php echo  MainMenu::widget(); ?>
                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg dashbard-1">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    USDT: <strong><?= (double)Yii::$app->user->identity->USDT_money; ?></strong>
                                    <b class="caret"></b>
                                </a>
                                    <?php \yii\widgets\Pjax::begin(['id'=>'balance_pjax',
                                        'options' => [
                                            'class' => 'dropdown-menu dropdown-alerts animated fadeInRight',
                                            'tag'=>'ul'
                                        ]]); ?>
                                    <li>
                                        <a>
                                            <div>
                                                <i class="fa fa-usd fa-fw"></i> USDT:
                                                <strong><?= (double)Yii::$app->user->identity->USDT_money; ?></strong>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a>
                                            <div>
                                                <i class="fa fa-btc fa-fw"></i> BTC:
                                                <strong><?= (double)Yii::$app->user->identity->BTC_money; ?></strong>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a>
                                            <div>
                                                <i class="fa fa-gbp fa-fw"></i> ETH:
                                                <strong><?= (double)Yii::$app->user->identity->ETH_money; ?></strong>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="text-center link-block">
                                            <button type="button"
                                                    class="btn btn-w-m btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#switchRate"
                                            >
                                                Обмен средств
                                            </button>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="<?= Url::to(['coins/transactions'])?>" class="link-btn">Транзакции</a>
                                    </li>
                                    <?php \yii\widgets\Pjax::end(); ?>
                            </li>
                            <li>
                                <button type="button"
                                        class="btn btn-w-m btn-primary"
                                        data-toggle="modal"
                                        data-target="#payments"
                                >
                                    Пополнить
                                </button>
                            </li>
                            <?php \yii\widgets\Pjax::begin(['id'=>'notification_pjax',
                                'options' => [
                                    'class' => 'dropdown bell',
                                    'tag'=>'li'
                                ]]); ?>
                            <?php echo  \app\widgets\NotificationWidget::widget(); ?>
                            <?php \yii\widgets\Pjax::end(); ?>
                            <li>
                                <div class="dropdown">
                                    <img alt="image" class="img-circle" src="../image/user_icon.png" />
                                    <a data-toggle="dropdown" class="dropdown-toggle styling-settings" href="#">
                                        <span class="text-muted text-xs block">
                                            <?php echo Yii::$app->user->identity->username ?>
                                            <b class="caret"></b>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                        <li><a href="<?=Url::to(['cabinet/accounts'])?>">Настройки</a></li>
                                        <li><a href="<?=Url::to(['cabinet/2fa'])?>">Двухфакторная авторизация</a></li>
                                        <li><a href="<?=Url::to(['cabinet/accounts'])?>">Мои биржи</a></li>
                                        <li><a href="<?= Url::to(['coins/transactions'])?>">Транзакции</a></li>
                                        <li><a href="mailbox.html">Уведомления</a></li>
                                        <li class="divider"></li>
                                        <li><form action="/site/logout" method="post">
                                                <input type="hidden"
                                                       name="_csrf"
                                                       value="3IVWs-2LhwVxDCcOrB3_EPNO5Fkx7VnyIsypYStsDrzrtwWG29nKVAlBQUHBSpRAsCWtMEOlFIF4u4QVGyZJ1Q==">
                                                <button type="submit" class="btn btn-link logout">
                                                    <i class="fa fa-sign-out"></i>
                                                    Выйти
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
               
                <?= $content ?>
              
            </div>
        </div>

        <div class="modal inmodal" id="payments" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <i class="fa fa-paypal modal-icon"></i>
                        <h4 class="modal-title">Пополнить баланс</h4>
                        <small class="font-bold">
                            Пополнением своего кошелька в нашей системе, вы получаете дополнительные возможности
                        </small>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="main-label" for="culture_main">
                                Выберете валюту в которой хотите произвести оплату:
                            </label>
                            <select class="form-control m-b main-select" id="culture_main">
                                <option value="BTC">BTC</option>
                                <option value="USDT">USDT</option>
                                <option value="ETH">ETH</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="main-label" for="money">Сумма:</label>
                            <input id="money" type="text" class="form-control" title="money" name="money">
                        </div>
                    </div>
                    <div class="modal-body hidden">
                        <div id="answer" class="answer">
                            <label class="control-label">Адресс Кошелька</label>
                            <p class="address form-copy-text" onclick="copyText(this);"></p>
                            <div class="row"><div class="col-md-6"> <div class="form-group">
                                        <label class="control-label">Сума в <span class="currency1"></span></label>
                                        <p class="text-am-cur">
                                            <span class="amount1"></span>
                                            <span class="currency1"></span>
                                        </p>
                                    </div></div>
                                <div class="col-md-6"><div class="form-group">
                                        <label class="control-label">Сума в BTC</label>
                                        <p class="text-am-cur">
                                            <span class="amount2"></span>
                                            <span class="currency2">BTC</span>
                                        </p>
                                    </div></div></div>
                            <div class="img-qr-block">
                                <img src="" class="qrcode_url">
                            </div>
                            <a class="status_url" href="" style="display: block;margin-top: 10px">Подробнее</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                        <button id="send" type="button" class="btn btn-primary">Пополнить</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal inmodal" id="switchRate" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <i class="fa fa-paypal modal-icon"></i>
                        <h4 class="modal-title">Обмен средств</h4>
                        <small class="font-bold">
                            Пополнением своего кошелька в нашей системе, вы получаете дополнительные возможности
                        </small>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="main-label" for="culture_main_switch1">
                                Выберете валюту которую хотите списать с баланса:
                            </label>
                            <select class="form-control m-b main-select" id="culture_main_switch1">
                                <option value="BTC">BTC (<?= (double)Yii::$app->user->identity->BTC_money; ?>)</option>
                                <option value="USDT">USDT (<?= (double)Yii::$app->user->identity->USDT_money; ?>)</option>
                                <option value="ETH">ETH (<?= (double)Yii::$app->user->identity->ETH_money; ?>)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="main-label" for="culture_main_switch2">
                                Выберете валюту в которую хотите перевести деньги:
                            </label>
                            <select class="form-control m-b main-select" id="culture_main_switch2">
                                <option value="BTC">BTC (<?= (double)Yii::$app->user->identity->BTC_money; ?>)</option>
                                <option value="USDT">USDT (<?= (double)Yii::$app->user->identity->USDT_money; ?>)</option>
                                <option value="ETH">ETH (<?= (double)Yii::$app->user->identity->ETH_money; ?>)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="main-label" for="value_switch">Количество:</label>
                            <input id="value_switch" type="text" title="money" name="money" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                        <button id="switch_coin" type="button" class="btn btn-primary">Обменять</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal inmodal" id="withdraw" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <i class="fa fa-paypal modal-icon"></i>
                        <h4 class="modal-title">Вывести баланс</h4>
                        <small class="font-bold">
                            Пополнением своего кошелька в нашей системе, вы получаете дополнительные возможности
                        </small>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="main-label" for="culture_main_withdraw1">
                                Выберете валюту которую хотите списать с баланса:
                            </label>
                            <select class="form-control m-b main-select" id="culture_main_withdraw1">
                                <option value="BTC">BTC (<?= (double)Yii::$app->user->identity->BTC_money; ?>)</option>
                                <option value="USDT">USDT (<?= (double)Yii::$app->user->identity->USDT_money; ?>)</option>
                                <option value="ETH">ETH (<?= (double)Yii::$app->user->identity->ETH_money; ?>)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="main-label" for="money_withdraw">Цена:</label>
                            <input id="money_withdraw" type="text" title="money" name="money" class="form-control">
                        </div>
<!--                        <div class="form-group">-->
<!--                            <label class="main-label" for="culture_main_withdraw2">-->
<!--                                Выберите валюту на которую хотите получить деньги:-->
<!--                            </label>-->
<!--                            <select class="form-control m-b main-select" id="culture_main_withdraw2">-->
<!--                                <option value="BTC">BTC</option>-->
<!--                                <option value="LTC">LTC</option>-->
<!--                                <option value="ETH">ETH</option>-->
<!--                            </select>-->
<!--                        </div>-->
                        <div class="form-group">
                            <label class="main-label" for="purse_withdraw">Адресс кошелька:</label>
                            <input id="purse_withdraw"
                                   type="text"
                                   title="purse_withdraw"
                                   name="purse_withdraw"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="modal-body hidden">
                        <div id="answer_withdraw" class="answer">
                            <label class="control-label">Адресс Кошелька</label>
                            <p class="address form-copy-text" onclick="copyText(this);"></p>
                            <div class="row"><div class="col-md-6"> <div class="form-group">
                                        <label class="control-label">Сума в <span class="currency1"></span></label>
                                        <p class="text-am-cur">
                                            <span class="amount1"></span>
                                            <span class="currency1"></span>
                                        </p>
                                    </div></div>
                                <div class="col-md-6"><div class="form-group">
                                        <label class="control-label">Комиссия</label>
                                        <p class="text-am-cur">
                                            <span class="amount2"></span>
                                            <span class="currency2">BTC</span>
                                        </p>
                                    </div></div></div>
                            <div class="img-qr-block">
                                <img src="" class="qrcode_url">
                            </div>
                            <a class="status_url" href="">Подробнее</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                        <button id="send_withdraw" type="button" class="btn btn-primary">Вывести</button>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
