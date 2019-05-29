<?php

use app\models\User;
use yii\bootstrap\Html;
use yii\helpers\Url;

$this->title = 'Рефералы';
?>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><strong><?=$this->title?></strong></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <div class="row">


                        <div class="panel-heading">
                            <div class="panel-options">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-admin-1">Общие настройки</a></li>
                                    <li><a data-toggle="tab" href="#tab-admin-2">Ваши рефералы</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content pull-content">

                            <div id="tab-admin-1" class="tab-pane active">

                                    <div class="col-lg-12">
                                        <div class="setting_block m-t col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Создать промокод</label>
                                                <div class="col-md-5">
                                                    <input id="promocode_ref" type="text" class="form-control value setting" value="">
                                                </div>
                                                <div class="col-md-3">
                                                    <button id="referral_code_create" type="button" class="btn btn-w-m btn-primary btn-sm">Создать</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php \yii\widgets\Pjax::begin(['id'=>'referral_pjax']); ?>
                                <div class="ibox-content">
                                <div class="table-responsive">
                                    <table id="data_table" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                        <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Промокод</th>
                                            <th>Created at</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($promocodes as $n => $promocode) :?>
                                            <tr class="">
                                                <td><?=$promocode->id?></td>
                                                <td><?=$promocode->promocode?></td>
                                                <td><?=$promocode->created_at?></td>
                                                <td>
                                                    <button class="btn btn-warning label label-success" onclick="deletePromocode(<?=$promocode->id?>)">Удалить</button>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                                <script>
                                    dataTablePajax();
                                </script>
                                <?php \yii\widgets\Pjax::end(); ?>

                            </div>
                            </div>

                            <div id="tab-admin-2" class="tab-pane">

                                <div class="table-responsive">
                                    <table id="data_table" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                        <thead>
                                        <tr>
                                            <th>Имя юзера</th>
                                            <th>Промокод активации</th>
                                            <th>Дата регистрации</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($user_referrals as $user) :?>
                                            <tr>
                                                <td><?=$user['username']?></td>
                                                <td><?=$user['promocode']?></td>
                                                <td><?=$user['created_at']?></td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>







    <div class="modal inmodal" id="admin_more_info_user" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Информация о юзере</h4>
                </div>
                <div class="modal-body">

                    <div class="panel blank-panel admin-modal-panel">
                        <div class="panel-heading">
                            <div class="panel-options">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1">Общие данные</a></li>
                                    <li><a data-toggle="tab" href="#tab-2">Финансы</a></li>
                                    <li><a data-toggle="tab" href="#tab-3">Уведомления</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">
                            <?php \yii\widgets\Pjax::begin(['id'=>'admin_user_more_info_pjax']); ?>
                            <div class="tab-content pull-content">

                                <div id="tab-1" class="tab-pane active">

                                    <div class="table-responsive">
                                        <table id="data_table" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NICKNAME</th>
                                                <th>USER_ROLE</th>
                                                <th>EMAIL</th>
                                                <th>telegram</th>
                                                <th>Phone</th>
                                                <th>Создан/Последнее действие</th>
                                                <th>logo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="">
                                                <td><?=$user_single->id?></td>
                                                <td><?=$user_single->username?></td>
                                                <td><?=$user_single->user_role?></td>
                                                <td><?=$user_single->email?></td>
                                                <td><?=$user_single->telegram?></td>
                                                <td><?=$user_single->phone?></td>
                                                <td><?=$user_single->created_at;?> / <?=$user_single->updated_at;?></td>
                                                <td>
                                                    <img src="<?=$user_single->logo_src;?>"
                                                         style="max-width: 50px;max-height: 50px;"/>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div id="tab-2" class="tab-pane">

                                    <div class="table-responsive">
                                    <table id="data_table" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                        <thead>
                                        <tr>
                                            <th>USDT_money</th>
                                            <th>ETH_money</th>
                                            <th>BTC_money</th>
                                            <th>BTC_money</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td><?=(double)$user_single->USDT_money?></td>
                                                <td><?=(double)$user_single->ETH_money?></td>
                                                <td><?=(double)$user_single->BTC_money?></td>
                                                <td><?=(double)$user_single->BTC_money?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>

                                    <h2>Транзакции</h2>
                                    <div class="table-responsive">
                                        <table id="data_table_modal_1" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                            <thead>
                                            <tr>
                                                <?php if (User::canAdmin()) :?>
                                                    <th>
                                                        #ID
                                                    </th>
                                                    <th>
                                                        Никнейм
                                                    </th>
                                                    <th>Email</th>
                                                    <th>Кошелек</th>
                                                <?php endif;?>
                                                <th>Тип</th>
                                                <th>Вид операции</th>
                                                <th>Original Currency</th>
                                                <th>Comment</th>
                                                <th>STATUS</th>
                                                <th>Time start</th>
                                                <th>Time end</th>
                                                <?php if (User::canAdmin()) :?>
                                                    <th>
                                                        Manual payout
                                                    </th>
                                                <?php endif;?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $transaction_statuses = [
                                                0=>'В выполнении',
                                                1=>'Выполнена',
                                            ] ?>
                                            <?php foreach ($transactions_single as $n => $transaction) :?>
                                                <tr class="">
                                                    <?php if (User::canAdmin()) :?>
                                                        <td>
                                                            <?=$transaction->user_id?>
                                                        </td>
                                                        <td>
                                                            <?=$transaction->user->username?>
                                                        </td>
                                                        <td>
                                                            <?=$transaction->user->email?>
                                                        </td>
                                                        <td><?=$transaction->user_purse?></td>
                                                    <?php endif;?>
                                                    <td class="<?php if ($transaction->type == "deposit" ) {echo "text-danger"; }
                                                    else if ($transaction->type == "withdraw") {echo "text-success"; } ?>">
                                                        <?=$transaction->type?>
                                                    </td>
                                                    <td>
                                                        <?=$transaction->sub_type?>
                                                    </td>
                                                    <td><?=(double)$transaction->amount1.' '.$transaction->currency1?> / <?=(double)$transaction->amount2.' '.$transaction->currency2?></td>
                                                    <td><?=$transaction->comment?></td>
                                                    <td><span class="label <?=($transaction->status == 1 ) ? "label-primary" : "label-warning" ?>">
                                        <?=$transaction_statuses[$transaction->status == 1] ?></span>
                                                    </td>
                                                    <td><?=$transaction->date_start?></td>
                                                    <td><?=$transaction->date_last?></td>
                                                    <?php if(Yii::$app->user->identity->user_role == "admin"):?>
                                                        <td>
                                                            <?php if($transaction->type === "coin" &&
                                                                $transaction->sub_type === "withdraw" &&
                                                                $transaction->status == 0):?>
                                                                <button class="btn btn-success label label-success" onclick="transationDone(<?=$transaction->id?>)">Выплатить</button>
                                                            <?php endif;?>
                                                        </td>
                                                    <?php endif;?>
                                                </tr>
                                            <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>

                                <div id="tab-3" class="tab-pane">

                                    <table id="data_table_modal_2" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                        <thead>
                                        <tr>
                                            <th>Сообщение</th>
                                            <th>Время</th>
                                            <th>Статус</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($notifications as $notification):?>
                                            <tr class="">
                                                <td><?=$notification->message?></td>
                                                <td><?=$notification->time?></td>
                                                <td><?=$notification->status?></td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                            <script>
                                if(typeof $ !== 'undefined') {
                                    let active_href = $('.admin-modal-panel .nav-tabs li.active a').attr('href');
                                    $('.admin-modal-panel .tab-content .tab-pane').removeClass('active');
                                    $(active_href).addClass('active');
                                }
                                dataTablePajax('#data_table_modal_1');
                                dataTablePajax('#data_table_modal_2');
                            </script>
                            <?php \yii\widgets\Pjax::end(); ?>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>






<script>
    function changeAdminSetting(id,_this) {
        event.preventDefault();
        let el = $(_this).closest('.setting_block'),
            data = {
            id: Number(id),
            value: el.find('input.setting, textarea.setting').val(),
        };
        console.log(data);

        $.ajax({
            type: "POST",
            url: "/admin/change-setting",
            data: data,
            success: function (msg) {
                console.log(msg);
                 showToastr(msg);

            }
        })
    }
    function banUser(id,ban,_this) {
        event.preventDefault();
        let el = $(_this).closest('.setting_block'),
            data = {
                user_id: Number(id),
                status: ban ? 0 : 10,
            };
        console.log(data);

        $.ajax({
            type: "POST",
            url: "/admin/ban-user",
            data: data,
            success: function (msg) {
                console.log(msg);
                 showToastr(msg);
            }
        })
    }
</script>

<?php echo $this->render('../informer/modals', [
        'categories'     => $categories,
        'sub_categories' => $sub_categories,
        'tags'           => $tags
]) ?>
<?php echo $this->render('../pool/modals') ?>
<?php echo $this->render('../market/modals', ['types' => $types,'user_marketplace' => $user_marketplace]) ?>