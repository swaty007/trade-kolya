
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\AdminSettings;
use yii\helpers\Url;
$this->title = 'FAQ';
?>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><strong><?= $this->title ?></strong></h2>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <?= AdminSettings::findOne(['id' => 15])->value?>
                </div>
            </div>

        </div>
    </div>
</div>
