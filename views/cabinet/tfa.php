<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app','Two factor Auth');

$success = Yii::$app->session->getFlash('success');
$warning = Yii::$app->session->getFlash('warning');
?>

<div class="token-sale-wrap security-page">
    <div class="row">
        <div class="col-md-12">
            <div class="token-block-wrap">
                <h3 class="title">
                    <?=Yii::t('app', '2-Factor Authorization')?>
                </h3>

                <div class="row google-auth">
                    <div class="col-md-8 col-lg-6">
                        <div class="image-sec-block fa2<?=Yii::$app->user->identity->google_tfa == 1 ? '' : '-disabled'?>">
                            <div class="img-block"></div>
                        </div>
                        <div class="text-block-secur">
                            <p class="text-red">
                                To Protect your Account with Two Factor Authorization do the following steps:
                            </p>
                            <div class="text-secur">
                                <p class="num">1.</p>
                                <span>
                                    Download one of these apps <a href="#">Google Authenticator</a> or <a href="#">Authy</a> from Google Play Market or Apple App Store.
                                </span>
                            </div>
                            <div class="text-secur">
                                <p class="num">2.</p>
                                <span id = "code">
                                   Scan QR Code or enter this key <strong><?=$user->google_se?></strong> <?=Yii::t('app', 'into your 2FA App.')?>
                                </span>
                            </div>
                            <div class="text-secur">
                                <p class="num">3.</p>
                                <span>
                                   After you scan QR Code or enter the key above, your app will provide you with a unique passcode. Enter that code below.
                                </span>
                            </div>
                        </div>

                        <form class="secure-form" action="">
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" class="input-text" id = "google_code" placeholder="Passcode">
                                </div>
                                <div class="col-xs-6">
                                    <button type="button" class="main-btn " id = "google_btn" onclick="activateGoogle()">Activate</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4 col-lg-6">
                        <div class="qr-code-block">
                            <p class="title-qr"><?=Yii::t('app', 'Scan this code with your 2FA App')?></p>
                            <div class="img-block" >
                                <div class="qr_image">
                                    <img src="<?=$qr_url?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div><script>
    var google_tfa = <?=Yii::$app->user->identity->google_tfa?>;
    var secret = '<?=Yii::$app->user->identity->google_se?>';
    window.onload = function ()
    {
        var err = true;
        if(google_tfa == 0){
            $("#google_btn").html('Activate');
        }else{
            $("#google_btn").html('Deactivate');
        }
        $('#f_new_pass_2').on('change', function () {
            err = true;
            var sel = $('#f_new_pass_2');

            if((sel.val() != $('#f_new_pass_1').val())){
                sel.parent().children().eq(1).text('<?=Yii::t('app', 'Confirm Password must be equal to New Password.')?>');
                err = false;
            }
            if(sel.val() < 6){
                sel.parent().children().eq(1).text('<?=Yii::t('app', 'Confirm Password should contain at least 6 characters.')?>');
                err = false;
            }
            if(err == false){
                sel.parent().removeClass('has-success').addClass('has-error');
            }else{
                sel.parent().children().eq(1).text('');
                sel.parent().removeClass('has-error').addClass('has-success');
            }
        });
        $('#submit-pass-btn').on('click', function () {
            if(err == false){
                event.preventDefault();
            }
        });



    };

    function activateGoogle(){
        var code = $('#google_code').val();
        if(code == 0){
            return alert('must be not empty');
        }
        if(window.confirm('Are you sure')){
            $.ajax({
                type: "POST",
                url: '<?=\yii\helpers\Url::toRoute('/cabinet/change-google')?>',
                data: {
                    code: code,
                    secret: secret
                },
                success: function (res) {
                    console.log(res);
                    if(res['status'] == 'success'){
                        var data = res['data'];
                        if(data['type'] == 1){
                            $('.image-sec-block').removeClass('fa2-disabled').addClass('fa2');
                            $('#google_btn').html('Deactivate');
                        }
                        if(data['type'] == 0){
                            $('#google_btn').html('Activate');
                            $('#code strong').html(data['secret']);
                            var qr = "<image id = 'qr-image' alt = '1' src = " + data['url'] + "></img>";
                            secret = data['secret'];
                            $('.qr_image').html(qr);
                            $('.image-sec-block').removeClass('fa2').addClass('fa2-disabled');
                        }
                    }else{
                        return alert(res['data']);
                    }
                }
            });
        }
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
