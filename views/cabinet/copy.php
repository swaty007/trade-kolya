
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Url;
$this->title = 'Копирование трейдеров';
?>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><?= $this->title ?></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Фильтры</h5>
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
                                <div class="col-lg-12" style="margin-bottom: 10px">
                                    <select id="copy_filter_marketplace"
                                            data-placeholder="Выбор биржи"
                                            multiple
                                            class="chosen-select"
                                            tabindex="2">
                                        <?php foreach ($marketplaces as $marketplace) : ?>
                                            <option value="<?= $marketplace['marketplace_id'] ?>" <?php if (isset($select->marketplace)) if (in_array($marketplace['marketplace_id'], $select->marketplace)) echo 'selected' ?>><?= $marketplace['marketplace_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Информация</h5>
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
                                <div class="col-lg-12" style="margin-bottom: 10px">
                                    <h3><?php echo $information_title->value ?></h3>
                                    <p><?php echo $information_text->value ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel blank-panel">
                <div class="panel-heading">
                    <div class="panel-options">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Активные копирования</a></li>
                            <li><a data-toggle="tab" href="#tab-2">Мои копирования</a></li>
                            <li><a data-toggle="tab" href="#tab-3">Приобретенные копирования</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <?php \yii\widgets\Pjax::begin(['enablePushState'=>false]); ?>



                    <div class="tab-content pull-content">

                        <div id="tab-1" class="tab-pane active">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Таблица аккаунтов бирж</h5>
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
                                    <form method="POST">
                                        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                                        <table id="data_table_1" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                            <thead>
                                            <tr>
                                                <th>Фото</th>
                                                <th>Никнейм</th>
                                                <th>Биржа</th>
                                                <th>Риски</th>
                                                <th>Портфель в USDT</th>
                                                <th>Успешных/неуспешных сделок</th>
                                                <th>Стоимость за подключение</th>
                                                <th>Профит</th>
                                                <th>Действия</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($user_marketplaces as $user_marketplace) { ?>
                                                <tr>
                                                    <td><img src="<?= $user_marketplace->user->logo_src != null ? $user_marketplace->user->logo_src : '../image/user_icon.png';?>" alt="" class="image-table"></td>
                                                    <td><?= $user_marketplace->user->username;?></td>
                                                    <td><?= $user_marketplace->marketplace->marketplace_name;?></td>
                                                    <td><?= $user_marketplace->risk;?></td>
                                                    <td><?= $user_marketplace->api_money_usdt;?></td>
                                                    <td><?= $user_marketplace->amount_deals_success . '/' . $user_marketplace->amount_deals_error;?></td>
                                                    <td><?= $user_marketplace->pay_copy;?></td>
                                                    <td><?= $user_marketplace->profit_percent;?></td>
                                                    <td>
                                                        <a class="btn btn-outline btn-info btn-xs table-btn-style" onclick="openModalMarketPlaceInform(<?= $user_marketplace->user_marketplace_id; ?>)">Подробности</a>
                                                        <a class="btn btn-outline btn-primary btn-xs table-btn-style" onclick="buyCopy(<?= $user_marketplace->user_marketplace_id; ?>)">Подключиться</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Таблица аккаунтов бирж</h5>
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
                                    <form  action="" method="POST">
                                        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                                        <table id="data_table_2" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                            <thead>
                                            <tr>
                                                <th>Фото</th>
                                                <th>Никнейм</th>
                                                <th>Биржа</th>
                                                <th>Риски</th>
                                                <th>Портфель в USDT</th>
                                                <th>Успешных/неуспешных сделок</th>
                                                <th>Стоимость за подключение</th>
                                                <th>Профит</th>
                                                <th>Действия</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($user_marketplaces_my as $user_marketplace) { ?>
                                                <tr>
                                                    <td><img src="<?= $user_marketplace->user->logo_src != null ? $user_marketplace->user->logo_src : '../image/user_icon.png';?>" alt="" class="image-table"></td>
                                                    <td><?= $user_marketplace->user->username;?></td>
                                                    <td><?= $user_marketplace->marketplace->marketplace_name;?></td>
                                                    <td><?= $user_marketplace->risk;?></td>
                                                    <td><?= $user_marketplace->api_money_usdt;?></td>
                                                    <td><?= $user_marketplace->amount_deals_success . '/' . $user_marketplace->amount_deals_error;?></td>
                                                    <td><?= $user_marketplace->pay_copy;?></td>
                                                    <td><?= $user_marketplace->profit_percent;?></td>
                                                    <td>
                                                        <a class="btn btn-outline btn-info btn-xs table-btn-style" onclick="openModalMarketPlaceInform(<?= $user_marketplace->user_marketplace_id; ?>)">Подробности</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Таблица аккаунтов бирж</h5>
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
                                    <form  action="" method="POST">
                                        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                                        <table id="data_table_3" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                            <thead>
                                            <tr>
                                                <th>Фото</th>
                                                <th>Никнейм</th>
                                                <th>Биржа</th>
                                                <th>Риски</th>
                                                <th>Портфель в USDT</th>
                                                <th>Успешных/неуспешных сделок</th>
                                                <th>Стоимость за подключение</th>
                                                <th>Профит</th>
                                                <th>Действия</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php foreach ($user_marketplaces_buy->marketplace as $user_marketplace): ?>
                                                <tr>
                                                    <td><img src="<?= $user_marketplace->user->logo_src != null ? $user_marketplace->user->logo_src : '../image/user_icon.png';?>" alt="" class="image-table"></td>
                                                    <td><?= $user_marketplace->user->username;?></td>
                                                    <td><?= $user_marketplace->marketplace->marketplace_name;?></td>
                                                    <td><?= $user_marketplace->risk;?></td>
                                                    <td><?= $user_marketplace->api_money_usdt;?></td>
                                                    <td><?= $user_marketplace->amount_deals_success . '/' . $user_marketplace->amount_deals_error;?></td>
                                                    <td><?= $user_marketplace->pay_copy;?></td>
                                                    <td><?= $user_marketplace->profit_percent;?></td>
                                                    <td>
                                                        <a class="btn btn-outline btn-info btn-xs table-btn-style" onclick="openModalMarketPlaceInform(<?= $user_marketplace->user_marketplace_id; ?>)">Подробности</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        dataTablePajax();
                        if(typeof $ !== 'undefined') {
                            let active_href = $('.nav-tabs li.active a').attr('href');
                            $('.tab-content .tab-pane').removeClass('active');
                            $(active_href).addClass('active');
                        }
                    </script>
                    <a id="marketplace_modal_pjax_link" class="hidden" href="/cabinet/copy-index?user_marketplace_id_modal=1"></a>
                    <?php \yii\widgets\Pjax::end(); ?>
                </div>
            </div>
         </div>
    </div>
</div>

<div class="modal inmodal" id="buy_copy_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-copy modal-icon"></i>
                <h4 class="modal-title">Копирование трейдера</h4>
            </div>
            <div class="modal-body">
                <p>Копировать трейдера?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button id="buy_copy" type="button" data-id="" class="btn btn-primary">Купить</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="inform_copy_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Подробности трейдера</h4>
            </div>
            <div class="modal-body">
                <?php \yii\widgets\Pjax::begin(['id'=>'marketplace_modal']); ?>
                <img src="<?= $marketplace_modal->user->logo_src != null ? $marketplace_modal->user->logo_src : '../image/user_icon.png';?>" alt="" class="image-table">
                <p>Риски: <strong><?= $marketplace_modal->risk;?></strong></p>
                <p>Подробности: <strong><?= $marketplace_modal->description;?></strong></p>
                <?php \yii\widgets\Pjax::end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>