<?php
use yii\helpers\Html;

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['coins/activation', 'token' => $code]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to confirm your withdraw:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>