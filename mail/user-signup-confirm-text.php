<?php

/* @var $user \common\entities\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/activation', 'token' => $user->email_confirm_token]);
?>
    Hello <?= $user->username ?>,

    Follow the link below to confirm your email:

<?= $confirmLink ?>