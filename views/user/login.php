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

        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email', 'onchange' => 'checkAccount(this.value)'])->label(false); ?>

        <?= $form->field($model, 'password')->passwordInput()->textInput(['placeholder' => 'Пароль', 'type' => 'password'])->label(false); ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"\">{input} {label}</div>\n<div class=\"col-lg-12\">{error}</div>",
        ])->label('Запомнить меня'); ?>

        <div class="recaptcha-block">
            <script src='https://www.google.com/recaptcha/api.js?render=<?=Yii::$app->params['capcha_frontkey'] ?>'></script>
            <textarea id="g-recaptcha-response"
                      name="g-recaptcha-response"
                      class="g-recaptcha-response"
                      style="width: 250px;height: 40px;border: 1px solid rgb(193, 193, 193);margin: 10px 25px;padding: 0px;resize: none;display: none;"></textarea>
            <script>
                grecaptcha.ready(function() {
                    grecaptcha.execute('<?=Yii::$app->params['capcha_frontkey'] ?>', {action: 'login'}).then(function(token) {
                      document.getElementById('g-recaptcha-response').value = token;
                    });
                });
            </script>
        </div>

        <span id="code_cont" style="display: none">
                <?= $form->field($model, 'code')->textInput(['placeholder' => Yii::t('app','2-FA Code')]) ?>
        </span>
        
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
        <p class="text-muted text-center"><small>У вас нет аккаунта?</small></p>
        <a class="btn btn-sm btn-white btn-block" href="<?php echo Url::to(['user/signup']); ?>">Создать аккаунт</a>

        <?php ActiveForm::end(); ?>
        <p class="m-t"> <small>&copy; TakeProfit <?= date('Y') ?></small> </p>
    </div>
</div>
<script>
    function checkAccount(email) {
        $.ajax({
            type: "POST",
            url: "<?=\yii\helpers\Url::toRoute('/user/check-account')?>",
            data: {email: email},
            success: function (msg) {
                if (msg == 1) {
                    $('#code_cont').css('display', 'block');
                } else {
                    $('#code_cont').css('display', 'none');
                }
            }
        });
    }
    window.addEventListener("load", function () {
        checkAccount($('#loginemailform-email').val());
    });
</script>