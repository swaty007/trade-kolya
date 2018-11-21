<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Вход пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">TP</h1>
        </div>
        <h3><?= Html::encode($this->title) ?></h3>
        
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => [
                'class' => 'm-t'
            ],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false); ?>

        <?php echo $form->field($model, 'password')->passwordInput()->textInput(['placeholder' => 'Пароль', 'type' => 'password'])->label(false); ?>

        <?php echo $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"\">{input} {label}</div>\n<div class=\"col-lg-12\">{error}</div>",
        ])->label('Запомнить меня'); ?>

        
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
        <p class="text-muted text-center"><small>У вас нет аккаунта?</small></p>
        <a class="btn btn-sm btn-white btn-block" href="<?php echo Url::to(['user/signup']); ?>">Создать аккаунт</a>

        <?php ActiveForm::end(); ?>
        <p class="m-t"> <small>&copy; TakeProfit <?= date('Y') ?></small> </p>
    </div>
</div>
