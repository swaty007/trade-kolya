<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'My Yii Application';
?>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2>Take Profit</h2>
    </div>
    <div class="col-lg-10">
        <h3>Личный кабинет</h3>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">     
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Меню</h5>
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
                    <nav>
                        <?php echo $menu; ?>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Редактирование</h5>
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
                    <?php
                $form = ActiveForm::begin(['id' => 'usermarketplace-form', 'layout' => 'horizontal',
                            'fieldConfig' => ['template' => "{label}\n<div class=\"col-sm-6\">{input}</div>\n<div class=\"col-sm-4\">{error}</div>",
                                'labelOptions' => ['class' => 'col-sm-2 control-label'],],]);
                ?>

                <?php echo $form->field($model, 'user_marketplace_id')->hiddenInput()->label(false); ?>

                <?php echo $form->field($model, 'name')->label('Название')->textInput(['autofocus' => true]); ?>

                <?php echo $form->field($model, 'marketplace_id')->label('Биржа')->dropDownList($marketplaces); ?>

                <?php echo $form->field($model, 'key')->label('Ключ')->textInput(); ?>

                <?php echo $form->field($model, 'secret')->label('Secret')->textInput(); ?>

                <?php echo $form->field($model, 'order')->label('Вес сортировки')->textInput(); ?>

                <?php $checkboxTemplate = '<div class="col-sm-2"></div><div class="col-sm-6"><div class="checkbox">{beginLabel}{input}{labelTitle}{endLabel}</div></div><div class="col-sm-4">{error}{hint}</div>'; ?>
                <?= $form->field($model, 'master')->checkbox([
                    'template' => $checkboxTemplate,
                    'label'=>'Мастер (разрешить повторять операции)',
                    'uncheck' => null
                ]);?>

                <?php echo $form->field($model, 'slave')->label('Мастер Id')->textInput(['readonly'=>true]); ?>
                

                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-4">
                        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'UserMarketplce-button']); ?>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-warning" id="SlaveClear" onclick="$('#usermarketplceform-slave').val(0);">Очистить</button>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-lg-offset-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Редактирование</h5>
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
                        <button class="button btn-primary" id="BtnFindMaster">Найти мастера (плечо)</button>
                        <div id="Masters"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>