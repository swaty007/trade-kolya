<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
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
</nav>


<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><?= Html::encode($this->title) ?></h2>
        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

        <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>
        <?php endif; ?>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Contact us</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12"><h3 class="m-t-none m-b">Sign in</h3>
                            <p>Sign in today for more expirience.</p>
                            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'email') ?>

                            <?= $form->field($model, 'subject') ?>

                            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                            ]) ?>

                            <div class="form-group">
                                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>