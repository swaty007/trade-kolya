<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = 'X capital';
?>
<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            
    <ul class="nav navbar-top-links navbar-left">
        <li>
            <a class="" href="/">Take Profit</a>
        </li>
        <?php if (Yii::$app->user->isGuest) { ?>
            <li><a href="/site/index">Для трейдеров</a></li>
            <li><a href="/site/about">Для инвестеров</a></li>
            <li><a href="/site/contact">О нас</a></li>
        <?php } else { ?>
            <li><a href="/site/index"><span class="glyphicon glyphicon-stats"></span> Трейдинг</a></li>
            <li><a href="/trader/top"><span class="glyphicon glyphicon-user"></span> Лучшие трейдеры</a></li>
            <li><a href="/site/index"><span class="glyphicon glyphicon-bullhorn"></span> Сигналы трейдеров</a></li>
            <li><a href="/site/index"><span class="glyphicon glyphicon-phone"></span> Информер</a></li>
        <?php } ?>
    </ul>
    <ul class="nav navbar-top-links navbar-right">
        <?php if (Yii::$app->user->isGuest) { ?>
            <li><a href="<?php echo Url::to(['user/login']); ?>"><i class="fa fa-sign-out"></i>Войти</a></li>
            <li><a href="<?php echo Url::to(['user/signup']); ?>"><i class="fa fa-sign-out"></i>Регистрация</a></li>
        <?php } else { ?>
            <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><?php echo Yii::$app->user->identity->username; ?> <span class="caret"></span></a>
                <ul id="w2" class="dropdown-menu">
                    <li><a href="<?= Url::to(['/cabinet/index'])?>" tabindex="-1">Кабинет</a></li>
                    <li><a href="<?= Url::to(['cabinet/accounts'])?>" tabindex="-1">Мои аккаунты</a></li>
                    <li><form action="/site/logout" method="post">
                            <input type="hidden" name="_csrf" value="3IVWs-2LhwVxDCcOrB3_EPNO5Fkx7VnyIsypYStsDrzrtwWG29nKVAlBQUHBSpRAsCWtMEOlFIF4u4QVGyZJ1Q=="><button type="submit" class="btn btn-link logout">Logout (<?php echo Yii::$app->user->identity->username; ?>)</button>
                        </form>
                    </li>
                </ul>
            </li>
        <?php } ?>
    </ul>
</nav>

<div id="indexpage">
    <img src="/image/index_content.jpg" style="width:100%;">
</div>