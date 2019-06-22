<?php

$this->title = 'Главная';

use app\models\AdminSettings; ?>
<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><?= $this->title ?></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content article">
                    <?= AdminSettings::findOne(['id' => 15])->value?>
                </div>
            </div>
        </div>
    </div>
</div>
