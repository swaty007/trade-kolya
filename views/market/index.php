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
        <h2><strong>Магазин</strong></h2>
    </div>
<?php if( Yii::$app->user->identity->user_role == "admin"):?>
    <div class="col-lg-10 btn-block-style">
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#market-create"><strong>Создать продукт</strong></button>
    </div>
<?php endif;?>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
            <div class="col-lg-12">
                <div class="panel blank-panel">

                    <div class="panel-heading">
                        <div class="panel-options">

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1">Активные продукты</a></li>
                                <li><a data-toggle="tab" href="#tab-2">Архивнные продукты</a></li>
                                <li><a data-toggle="tab" href="#tab-3">Купленые продукты</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <?php \yii\widgets\Pjax::begin(); ?>
                        <div class="tab-content pull-content">

                            <div id="tab-1" class="tab-pane active">
                                <?php foreach (array_chunk($markets_active, 4) as $row) :?>
                                    <div class="row">
                                        <?php foreach ($row as $market) :?>
                                        <div class="col-lg-3">
                                            <div class="widget lazur-bg p-xl">
                                                <img src="<?= $market->src ? $market->src : '/image/tp_image.png' ?>"  class="market_image" alt="market">
                                                <h2 class="market-title"><?=$market->title;?></h2>
                                                <ul class="list-unstyled m-t-md">
                                                    <li style="margin-bottom: 20px">
                                                        <span class="market-description"><?=$market->description;?></span>
                                                    </li>
                                                    <li>
                                                        <label>Стоимость:</label>
                                                        <span class="market-cost"><?=(double)$market->cost;?></span> $
                                                    </li>
                                                    <li>
                                                        <label>Тип:</label>
                                                        <span class="market-type"><?=$market->type;?></span>
                                                    </li>
                                                    <li>
                                                        <label>Срок действия апи(в днях):</label>
                                                        <span class="market-end"><?=$market->time_action;?></span>
                                                    </li>
                                                    <li>
                                                        <label>Количество апи:</label>
                                                        <span class="market-count_api"><?= $market->count_api?></span>
                                                    </li>
                                                    <li style="margin-top: 20px">
                                                        <button class="btn btn-success" type="button" onclick="buyMarket(<?=$market->id;?>,this)">Купить</button>
                                                        <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                            <button class="btn btn-warning" type="button" onclick="editMarket(<?=$market->id;?>,this)">Редактировать</button>
                                                            <button class="btn btn-danger" type="button" onclick="deleteMarket(<?=$market->id;?>,this)">Удалить</button>
                                                        <?php endif;?>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                                <?php endforeach;?>
                            </div>

                            <div id="tab-2" class="tab-pane">
                                <?php foreach (array_chunk($markets_archive, 4) as $row) :?>
                                <div class="row">
                                    <?php foreach ($row as $market) :?>
                                    <div class="col-lg-3">
                                        <div class="widget lazur-bg p-xl">

                                            <h2>
                                                <?=$market->title;?>
                                            </h2>
                                            <ul class="list-unstyled m-t-md">
                                                <li style="margin-bottom: 20px">
                                                    <?=$market->description;?>
                                                </li>
                                                <li>
                                                    <label>Стоимость:</label>
                                                    <?=(double)$market->cost;?> $
                                                </li>
                                                <li>
                                                    <label>Тип:</label>
                                                    <?=$market->type;?>
                                                </li>
                                                <li>
                                                    <label>Срок действия апи(в днях):</label>
                                                    <?=$market->time_action;?>
                                                </li>
                                                <li>
                                                    <label>Количество апи:</label>
                                                    <?= $market->count_api?>
                                                </li>
                                                <li style="margin-top: 20px">
                                                    <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                        <button class="btn btn-danger" type="button" onclick="deleteMarket(<?=$market->id;?>,this)">Удалить</button>
                                                    <?php endif;?>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                                <?php endforeach;?>
                            </div>

                            <div id="tab-3" class="tab-pane">
                                <?php foreach (array_chunk($markets_user, 4) as $row) :?>
                                    <div class="row">
                                        <?php foreach ($row as $market) :?>
                                        <div class="col-lg-3">
                                            <div class="widget lazur-bg p-xl">
                                                <h2>
                                                    <?=$market['title'];?>
                                                </h2>
                                                <ul class="list-unstyled m-t-md">
                                                    <li>
                                                        <label>Стоимость продукта:</label>
                                                        <?=(double)$market['cost'];?>
                                                    </li>
                                                    <li>
                                                        <label>Срок действия апи(в днях):</label>
                                                        <?=$market['time_action'];?>
                                                    </li>
                                                    <li>
                                                        <label>Количество апи:</label>
                                                        <?= $market['count_api']?> / <?= $market['count_api_full']?>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                        <?php endforeach;?>
                                    </div>
                                <?php endforeach;?>
                            </div>

                        </div>
                        <script>
                            if(typeof $ !== 'undefined') {
                                let active_href = $('.nav-tabs li.active a').attr('href');
                                $('.tab-content .tab-pane').removeClass('active');
                                $(active_href).addClass('active');
                            }
                        </script>
                        <?php \yii\widgets\Pjax::end(); ?>
                    </div>

                </div>
            </div>
        </div>
</div>

<?php echo $this->render('modals',['types'=>$types,'user_marketplace'=>$user_marketplace]) ?>