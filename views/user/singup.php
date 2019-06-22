<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use borales\extensions\phoneInput\PhoneInput;

$this->title = 'Регистрация пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name"><?= Html::img('@web/image/logo6.png', ['class' => '']); ?></h1>
        </div>
        <h3><?= Html::encode($this->title) ?></h3>
        <p>Заполните форму регистрации:</p>
        <?php $form = ActiveForm::begin([
            'id' => 'signup-form',
            'options' => [
                'class' => 'm-t'
            ],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Имя'])->label(false) ?>
    
        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false); ?>

<!--        --><?//= $form->field($model, 'phone')->textInput(['autofocus' => true, 'placeholder' => 'Номер Телефона'])->label(false); ?>

        <?= $form->field($model, 'phone')->widget(PhoneInput::className(), [
        'jsOptions' => [
        'preferredCountries' => ['ua', 'ru', 'pl'],
        ]
        ])->label(false);;?>

        <?= $form->field($model, 'password')->passwordInput()->textInput(['placeholder' => 'Пароль', 'type' => 'password'])->label(false);?>

        <?= $form->field($model, 'promo_code')->textInput(['autofocus' => true, 'placeholder' => 'Промокод'])->label(false); ?>

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
        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'signup-button']) ?>
        <p class="text-muted text-center"><small>Уже есть аккаунт?</small></p>
        <a class="btn btn-sm btn-white btn-block" href="<?php echo Url::to(['user/login']); ?>"">Вход</a>

        <?php ActiveForm::end(); ?>
    
        <p class="m-t"> <small>&copy; X capital <?= date('Y') ?></small> </p>
    </div>
</div>

