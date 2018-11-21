<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="middle-box text-center animated fadeInDown">
    <h1>Error</h1>
    <h3 class="font-bold"><?= Html::encode($this->title) ?></h3>

    <div class="error-desc">
        <?= nl2br(Html::encode($message)) ?>
        <p>The above error occurred while the Web server was processing your request.</p>
        <p>Please contact us if you think this is a server error. Thank you.</p>
    </div>
</div>


