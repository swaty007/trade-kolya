<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <nav id="w0" class="navbar-default navbar-fixed-top navbar-light bg-light navbar">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse"><span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span></button>

                        <a class="navbar-brand" href="/">Take Profit</a>
                    </div>
                    <div id="w0-collapse" class="collapse navbar-collapse">
                        <ul id="w1" class="navbar-nav nav">
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
                        <ul class="nav navbar-nav navbar-right">
                            <?php if (!Yii::$app->user->isGuest) { ?>
                                <li><a href="#"><i class="glyphicon glyphicon-btc"></i> 350 Пополнить</a></li>
                            <?php } ?>
                            <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Русский <span class="caret"></span></a>
                                <ul id="w2" class="dropdown-menu">
                                    <li><a href="#">Украинский</a></li><li><a href="#">English</a></li><li><a href="#">Español</a></li>
                                </ul>
                            </li>
                            <?php if (Yii::$app->user->isGuest) { ?>
                                <li><a href="<?php echo Url::to(['user/signup']); ?>"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                                <li><a href="<?php echo Url::to(['user/login']); ?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                            <?php } else { ?>
                                <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><?php echo Yii::$app->user->identity->username; ?> <span class="caret"></span></a>
                                    <ul id="w2" class="dropdown-menu">
                                        <li><a href="/cabinet" tabindex="-1">Кабинет</a></li>
                                        <li><a href="/cabinet/accounts" tabindex="-1">Мои аккаунты</a></li>
                                        <li><form action="/site/logout" method="post">
                                                <input type="hidden" name="_csrf" value="3IVWs-2LhwVxDCcOrB3_EPNO5Fkx7VnyIsypYStsDrzrtwWG29nKVAlBQUHBSpRAsCWtMEOlFIF4u4QVGyZJ1Q=="><button type="submit" class="btn btn-link logout">Logout (<?php echo Yii::$app->user->identity->username; ?>)</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>


            <?php
            /*
              NavBar::begin([
              'brandLabel' => Yii::$app->name,
              'brandUrl' => Yii::$app->homeUrl,
              'options' => [
              'class' => 'navbar-default navbar-fixed-top navbar-light bg-light',
              ],
              ]);

              $menuItems = [
              ['label' => 'Home', 'url' => ['/site/index']],
              ['label' => 'About', 'url' => ['/site/about']],
              ['label' => 'Contact', 'url' => ['/site/contact']],
              ];

              if (Yii::$app->user->isGuest) {
              $menuItems[] = ['label' => 'Войти', 'url' => ['/user/login']];
              $menuItems[] = ['label' => 'Регистрация', 'url' => ['/user/signup']];
              } else {
              $menuItems[] =
              [
              'label' => Yii::$app->user->identity->username, 'url' => '#',
              'items' => [
              ['label' => 'Кабинет', 'url' => '/cabinet'],
              '<li>'
              . Html::beginForm(['/site/logout'], 'post')
              . Html::submitButton(
              'Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']
              )
              . Html::endForm()
              . '</li>'
              ]
              ];
              /*$menuItems[] = '<li>'
              . Html::beginForm(['/site/logout'], 'post')
              . Html::submitButton(
              'Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']
              )
              . Html::endForm()
              . '</li>'; *//*
              }

              echo Nav::widget([
              'options' => ['class' => 'navbar-nav navbar-right'],
              'items' => $menuItems,
              ]);
              NavBar::end();
             */
            /*
            NavBar::begin([
                    //'brandLabel' => Yii::$app->name,
                    //'brandUrl' => Yii::$app->homeUrl,
                    //'options' => [
                    'class' => 'hidden',
                    //],
            ]);
            NavBar::end();
             * 
             */
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; TakeProfit <?= date('Y') ?></p>

                <p class="pull-right"><?php //= Yii::powered() ?></p>
            </div>
        </footer>

        <!-- <?php $this->endBody() ?> -->
    </body>
</html>
<?php $this->endPage() ?>
