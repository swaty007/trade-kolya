<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Двухфакторная аутентификация';

$success = Yii::$app->session->getFlash('success');
$warning = Yii::$app->session->getFlash('warning');
?>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><strong><?=$this->title?></strong></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Настройка</h5>
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
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6 text-center">
                                            <?=Yii::$app->user->identity->google_tfa == 1 ? '<i class="fa fa-5x fa-lock"></i>' : '<i class="fa fa-5x fa-unlock"></i>'?>
                                            <h3><?=$this->title?></h3>
                                            <p>С двухфакторной аутентификацией вы повышаете безопасность своего аккаунта, добавляя второй уровень проверки</p>
                                            <input type="checkbox" class="js-switch btn-tfa"  <?=Yii::$app->user->identity->google_tfa == 1 ? 'checked' : ''?> />
                                        </div>
                                        <div class="col-lg-6">

                                                <h3 class="title">
                                                    Для активации 2FA следуйте инструкциям ниже:
                                                </h3>
                                                <div class="text-block-secur">
                                                    <ol class="default-style-ol">
                                                        <li>Включите 2FA слева.</li>
                                                        <li>
                                                            <p>Установите приложение.</p>
                                                            <a href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank">
                                                                <img src="/image/app_store.png" class="image-store" alt="app_store">
                                                            </a>
                                                            <span>или</span>
                                                            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;hl=en" target="_blank">
                                                                <img src="/image/google_play.png" class="image-store" alt="google_play">
                                                            </a>
                                                        </li>
                                                        <li>
                                                            Отсканируйте QR-код или введите в скачаное преложение ключ.
                                                        </li>
                                                        <li>
                                                            Введите код аутентификации.
                                                        </li>
                                                    </ol>
                                                    <div class="block-ga-information hidden">
                                                        <div class="qr-code-block">
                                                            <div class="img-block" >
                                                                <div class="qr_image">
                                                                    <img src="<?=$qr_url?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-secur">
                                                            <span id="code">
                                                                <strong><?=$user->google_se?></strong>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="secure-form hidden" style="margin-top:20px">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <input type="text" class="form-control input-text" id="google_code" placeholder="Вставте пароль из приложения">
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <button type="button" class="btn btn-info main-btn" id="google_btn" onclick="activateGoogle()" style="margin-top: 10px">ОК</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var google_tfa = '<?=Yii::$app->user->identity->google_tfa?>',
        secret = '<?=Yii::$app->user->identity->google_se?>';

    window.onload = function () {
        $('.btn-tfa').on('change', function (e) {
            e.preventDefault();
            $('.block-ga-information').toggleClass('hidden');
            $('.secure-form').toggleClass('hidden');
        });
    };

    function activateGoogle(){
        var code = $('#google_code').val();

        if(code == 0){
            toastr['error']('Пароль не может быть пустым', '');
            return false;
        }
        console.log(code,secret);
        $.ajax({
            type: "POST",
            url: '<?=\yii\helpers\Url::toRoute('/cabinet/change-google')?>',
            data: {
                code: code,
                secret: secret
            },
            success: function (res) {
                console.log(res);
                console.log(res.data);
                console.log(res['data']);
                showToastr(res);
                if(res['msg'] == 'ok'){
                    var data = res['data'];
                    if(data['type'] == 1){
                        //$('.image-sec-block').removeClass('fa2-disabled').addClass('fa2');
                       // $('#google_btn').html('Deactivate');
                        $('#code strong').html(data['secret']);
                    }
                    if(data['type'] == 0){
                        //$('#google_btn').html('Activate');
                        $('#code strong').html(data['secret']);
                        var qr = "<image id = 'qr-image' alt = '1' src = " + data['url'] + "></img>";
                        secret = data['secret'];
                        $('.qr_image').html(qr);
                        $('.image-sec-block').removeClass('fa2').addClass('fa2-disabled');
                    }
                }
            }
        });

    }

    function doAction(v)
    {
        if(v === true)
        {
            $('#security_block').show('fast');
            // Activate();
        } else {
            $('#security_block').hide('fast');
            Deactivate();
        }
    }
</script>
