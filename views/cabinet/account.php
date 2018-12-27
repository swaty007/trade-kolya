<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Редактирование биржи';
?>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><strong><?= $this->title ?></strong></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">     
    <div class="row">
        <div class="col-lg-12">
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
                $form = ActiveForm::begin(['id' => 'usermarketplceform-slave', 'layout' => 'horizontal',
                            'fieldConfig' => ['template' => "{label}\n<div class=\"col-sm-6\">{input}</div>\n<div class=\"col-sm-4\">{error}</div>",
                                'labelOptions' => ['class' => 'col-sm-2 control-label'],],]);
                ?>

                <?php echo $form->field($model, 'user_marketplace_id')->hiddenInput()->label(false); ?>

                <?php echo $form->field($model, 'name')->label('Название')->textInput(['autofocus' => true]); ?>

                <?php echo $form->field($model, 'marketplace_id')->label('Биржа')->dropDownList($marketplaces, [
                    'options'=> [ Yii::$app->request->get('marketplace_id') => ["Selected"=>true]]
                ]); ?>

                <?php echo $form->field($model, 'key')->label('Ключ')->textInput(); ?>

                <?php echo $form->field($model, 'secret')->label('Secret')->textInput(); ?>

                <?php echo $form->field($model, 'order')->label('Вес сортировки')->textInput(); ?>

                <?php $checkboxTemplate = '<div class="col-sm-2"></div><div class="col-sm-6"><div class="checkbox">{beginLabel}{input}{labelTitle}{endLabel}</div></div><div class="col-sm-4">{error}{hint}</div>'; ?>
                <?= $form->field($model, 'is_seen_activated')->checkbox([
                    'template' => $checkboxTemplate,
                    'label'=>'Мастер (разрешить повторять операции)',
                    'uncheck' => null,
                    'onchange' => 'activateIsSeen(this.checked)'
                ]);?>
                <?= $form->field($model, 'master')->checkbox([
                    'template' => $checkboxTemplate,
                    'label'=>'Мастер (разрешить повторять операции)',
                    'uncheck' => null,
                ]);?>
                <div id="copy_box" class="<?=$model->is_seen_activated == 0 ? 'hidden': ''?>">
                    <?php echo $form->field($model, 'risk')
                        ->label('Риск')
                        ->dropDownList(['low' => 'low', 'medium' => 'medium', 'high' => 'high']); ?>
                    <?php echo $form->field($model, 'amount_deals_success')->label('Количество успешных сделок')->textInput(); ?>
                    <?php echo $form->field($model, 'amount_deals_error')->label('Количество не успешных сделок')->textInput(); ?>
                    <?php echo $form->field($model, 'api_money_usdt')->label('Количество денег на бирже')->textInput(); ?>
                    <?php echo $form->field($model, 'profit_percent')->label('Процент')->textInput(); ?>
                    <?php echo $form->field($model, 'pay_copy')->label('Стоимость копирования')->textInput(); ?>
                    <?php echo $form->field($model, 'description')->label('Описание')->textarea(['rows' => '6']); ?>
                </div>

                <?php echo $form->field($model, 'slave')->label('Мастер Id')->textInput(['readonly'=>true]); ?>

                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-4">
                        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'UserMarketplce-button']); ?>
                        <a class="btn btn-default" href="/cabinet/accounts"> Отмена </a>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-warning" id="SlaveClear" onclick="$('input, textarea').val('');">Очистить</button>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
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

<script>
    function activateIsSeen($value) {
        $('#copy_box').toggleClass('hidden');
    }
</script>