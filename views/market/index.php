<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'Магазин';
?>
<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2>Take Profit</h2>
    </div>
    <div class="col-lg-10">
        <h3>Магазин</h3>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
            <div class="col-lg-12">
                <div class="panel blank-panel">

                    <div class="panel-heading">
                        <div class="panel-title m-b-md">
                            <h4>Пулы</h4>
                            <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#market-create"><strong>Создать продукт</strong></button>
                            <?php endif;?>
                        </div>
                        <div class="panel-options">

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1">Активные продукты</a></li>
                                <li><a data-toggle="tab" href="#tab-2">Архивнные продукты</a></li>
                                <li><a data-toggle="tab" href="#tab-3">Купленые продукты</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="tab-content pull-content">

                            <div id="tab-1" class="tab-pane active">
                                <div class="row row-flex">
                                    <?php foreach ($markets_active as $market):?>
                                        <div class="col-lg-4 pool_block col-flex">
                                            <div class="panel panel-default market_block">
                                                <div class="panel-heading">
                                                    <strong class="market-title"><?=$market->title;?></strong>
                                                </div>
                                                <div class="panel-body">
                                                    <p class="style-pull-card market-type">Тип продукта: <strong><?=$market->type;?></strong></p>
                                                    <p class="style-pull-card market-description">Описание продукта: <span><?=$market->description;?></span></p>
                                                    <p class="style-pull-card market-cost">Стоимость продукта: <strong><?=(double)$market->cost;?></strong></p>
                                                    <p class="style-pull-card market-end">Срок действия апи(в днях): <strong><?=$market->time_action;?></strong></p>
                                                    <p class="style-pull-card market-count_api">Количество апи: <strong><?= $market->count_api?></strong></p>
                                                    <p class="style-pull-card market-date_create">Дата создание: <strong><?= $market->date_create?></strong></p>
                                                    <p class="style-pull-card market-date_update">Дата обновления: <strong><?= $market->date_update?></strong></p>
                                                </div>
                                                <div class="panel-footer">
                                                    <button class="btn btn-primary" type="button" onclick="buyMarket(<?=$market->id;?>,this)">Купить</button>
                                                    <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                        <button class="btn btn-info" type="button" onclick="editMarket(<?=$market->id;?>,this)">Редактировать</button>
                                                        <button class="btn btn-danger" type="button" onclick="deleteMarket(<?=$market->id;?>,this)">Удалить</button>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </div>

                            <div id="tab-2" class="tab-pane">
                                <div class="row row-flex">
                                    <?php foreach ($markets_archive as $market):?>
                                        <div class="col-lg-4 pool_block col-flex">
                                            <div class="panel panel-default market_block">
                                                <div class="panel-heading">
                                                    <strong class="pull-title"><?=$market->title;?></strong>
                                                </div>
                                                <div class="panel-body">
                                                    <p class="style-pull-card market-type">Тип продукта: <strong><?=$market->type;?></strong></p>
                                                    <p class="style-pull-card market-description">Описание продукта: <span><?=$market->description;?></span></p>
                                                    <p class="style-pull-card market-cost">Стоимость продукта: <strong><?=(double)$market->cost;?></strong></p>
                                                    <p class="style-pull-card market-end">Срок действия апи(в днях): <strong><?=$market->time_action;?></strong></p>
                                                    <p class="style-pull-card market-count_api">Количество апи: <strong><?= $market->count_api?></strong></p>
                                                    <p class="style-pull-card market-date_create">Дата создание: <strong><?= $market->date_create?></strong></p>
                                                    <p class="style-pull-card market-date_update">Дата обновления: <strong><?= $market->date_update?></strong></p>
                                                </div>
                                                <div class="panel-footer">
                                                    <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                        <button class="btn btn-danger" type="button" onclick="deleteMarket(<?=$market->id;?>,this)">Удалить</button>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </div>

                            <div id="tab-3" class="tab-pane">
                                <div class="row">
                                    <?php foreach ($markets_user as $market) :?>
                                        <div class="col-lg-3">
                                            <div class="widget navy-bg p-xl">

                                                <h2>
                                                    <?=$market->title;?>
                                                </h2>
                                                <ul class="list-unstyled m-t-md">
                                                    <li>
                                                        <label>Стоимость продукта:</label>
                                                        <?=(double)$market->cost;?>
                                                    </li>
                                                    <li>
                                                        <label>Срок действия апи(в днях):</label>
                                                        <?=$market->time_action;?>
                                                    </li>
                                                    <li>
                                                        <label>Количество апи:</label>
                                                        <?= $market->count_api?>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>

<?php echo $this->render('modals',['types'=>$types,'user_marketplace'=>$user_marketplace]) ?>