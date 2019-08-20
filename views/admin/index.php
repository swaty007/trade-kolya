<?php

use app\models\User;
use yii\bootstrap\Html;
use yii\helpers\Url;

$this->title = 'Админка';
?>




<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><strong>Админка</strong></h2>
    </div>
    <div class="col-lg-12 btn-block-style">
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#pull"><strong>Создать новый пул</strong></button>
        <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#informer-create"><strong>Создать новость</strong></button>
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#market-create"><strong>Создать продукт</strong></button>
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
                                    <li><a data-toggle="tab" href="#tab-admin-2">Пользователи</a></li>
                                    <li><a data-toggle="tab" href="#tab-admin-3">Транзакции</a></li>
                                    <li><a data-toggle="tab" href="#tab-admin-4">Рефералы</a></li>
                                    <li><a data-toggle="tab" href="#tab-admin-5">FAQ</a></li>
                                    <li><a data-toggle="tab" href="#tab-admin-6">Титулка</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content pull-content">

                            <div id="tab-admin-1" class="tab-pane active">

                                <?php foreach ($admin_settings as $setting) :?>
                                    <?php if ($setting->id == 15 || $setting->id == 16) {continue;};?>
                                    <div class="col-lg-12">
                                        <div class="setting_block m-t col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label"><?=$setting->name?></label>




                                                <div class="col-md-5">
                                                    <?php if( in_array($setting->id, [3,9,12] )) :?>
                                                        <textarea type="text" class="form-control value setting" value="<?=$setting->value?>"><?=$setting->value?></textarea>
                                                    <?php else:?>
                                                        <input type="text" class="form-control value setting" value="<?=$setting->value?>">
                                                    <?php endif;?>
                                                </div>
                                                <div class="col-md-3">
                                                    <button onclick="changeAdminSetting(<?=$setting->id?>,this)" type="button" class="btn btn-w-m btn-primary btn-sm">Изменить</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach?>

                            </div>

                            <div id="tab-admin-2" class="tab-pane">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                        <table id="data_table" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NICKNAME</th>
                                                <th>USER_ROLE</th>
                                                <th>EMAIL</th>
<!--                                                <th>USDT_money</th>-->
<!--                                                <th>ETH_money</th>-->
<!--                                                <th>BTC_money</th>-->
<!--                                                <th>BTC_money</th>-->
                                                <th>Статус акаунта</th>
                                                <th>Создан/Последнее действие</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($users as $user):?>
                                                <tr class="">
                                                    <td><?=$user->id?></td>
                                                    <td><?=$user->username?></td>
                                                    <td>
                                                        <select class="user-role-change" data-id="<?=$user->id?>">
                                                            <?php foreach ($user_roles as $role):?>
                                                                <option <?php if ($role == $user->user_role) echo "selected" ?> value="<?=$role?>"><?=$role?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </td>
                                                    <td><?=$user->email?></td>
<!--                                                    <td>--><?//=(double)$user->USDT_money?><!--</td>-->
<!--                                                    <td>--><?//=(double)$user->ETH_money?><!--</td>-->
<!--                                                    <td>--><?//=(double)$user->BTC_money?><!--</td>-->
<!--                                                    <td>--><?//=(double)$user->BTC_money?><!--</td>-->
                                                    <td>
                                                        <?php switch ($user->status){
                                                            case 10: echo 'STATUS_ACTIVE';break;
                                                            case 1 : echo 'STATUS_WAIT_ACTIVATION';break;
                                                            case 0 : echo 'STATUS_DELETED';break;
                                                        };?>
                                                    </td>
                                                    <td><?=$user->created_at;?> / <?=$user->updated_at;?></td>
                                                    <td>
                                                        <a class="pjax-modal-btn btn label label-success" href="<?= Url::to(['admin/index','user_id'=>$user->id])?>">Подробнее</a>
                                                        <?php if ($user->status == 10):?>
                                                            <a onclick="banUser(<?=$user->id?>, true, this)" href="#" class="btn label label-success">Забанить</a>
                                                        <?php elseif ($user->status == 0):?>
                                                            <a onclick="banUser(<?=$user->id?>, false, this)" href="#" class="btn label label-success">Разбанить</a>
                                                        <?php endif;?>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <script>
                                            dataTablePajax();
                                            document.addEventListener('DOMContentLoaded',function () {
                                                $(document).pjax('a.pjax-modal-btn', '#admin_user_more_info_pjax');
                                                $("#admin_user_more_info_pjax").on('pjax:send', function() {
                                                    $('#admin_more_info_user').modal('show');
                                                })
                                            })
                                        </script>
                                    </div>
                                </div>

                            </div>

                            <div id="tab-admin-3" class="tab-pane">

                                <?php \yii\widgets\Pjax::begin(['id'=>'transactions_pjax']); ?>
                                <div class="table-responsive">
                                <table id="data_table_transactions" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
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
                                        -10=> 'Отменена',
                                        -1 => 'Возврат'
                                    ] ?>
                                    <?php foreach ($transactions as $n => $transaction) :?>
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
                                        <?=$transaction_statuses[$transaction->status] ?></span>
                                            </td>
                                            <td><?=$transaction->date_start?></td>
                                            <td><?=$transaction->date_last?></td>
                                            <?php if(User::canAdmin()):?>
                                                <td>
                                                    <?php if($transaction->type === "coin" &&
                                                        $transaction->sub_type === "withdraw" &&
                                                        $transaction->status == 0):?>
                                                        <button class="btn btn-success label label-success" onclick="transactionDone(<?=$transaction->id?>,'#transactions_pjax')">Выплатить</button>
                                                        <button class="btn btn-warning label label-success" onclick="transactionReturn(<?=$transaction->id?>,'#transactions_pjax)">Отменить</button>
                                                    <?php endif;?>
                                                </td>
                                            <?php endif;?>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                                </div>
                                <script>
                                    dataTablePajax("#data_table_transactions");
                                </script>
                                <?php \yii\widgets\Pjax::end(); ?>

                            </div>

                            <div id="tab-admin-4" class="tab-pane">
                                <div class="table-responsive">
                                    <table id="data_table" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                        <thead>
                                        <tr>
                                            <th>Имя юзера который пришел</th>
                                            <th>Промокод активации</th>
                                            <th>Дата регистрации</th>
                                            <th>Имя юзера к которому пришли</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($user_referrals as $user) :?>
                                            <tr>
                                                <td><?=$user['username']?></td>
                                                <td><?=$user['promocode']?></td>
                                                <td><?=$user['created_at']?></td>
                                                <td><?=$user['username_parent']?></td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="tab-admin-5" class="tab-pane">
                                <div class="col-lg-12">
                                    <div class="setting_block m-t col-md-12">
                                        <div class="form-group row">
                                            <?php foreach ($admin_settings as $setting) :?>
                                                <?php if ($setting->id == 15):?>
                                            <label class="col-md-3 col-form-label"><?=$setting->name?></label>
                                            <div class="col-md-9">
                                                <div class="summernote"><?=$setting->value?></div>
                                                <button data-type="summernote" onclick="changeAdminSetting(<?=$setting->id?>,this)" type="button" class="btn btn-w-m btn-primary btn-sm">Изменить</button>
                                            </div>
                                                    <?php break;endif;?>
                                            <?php endforeach?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-admin-6" class="tab-pane">
                                <div class="col-lg-12">
                                    <div class="setting_block m-t col-md-12">
                                        <div class="form-group row">
                                            <?php foreach ($admin_settings as $setting) :?>
                                                <?php if ($setting->id == 16):?>
                                                    <label class="col-md-3 col-form-label"><?=$setting->name?></label>
                                                    <div class="col-md-9">
                                                        <div class="summernote"><?=$setting->value?></div>
                                                        <button data-type="summernote" onclick="changeAdminSetting(<?=$setting->id?>,this)" type="button" class="btn btn-w-m btn-primary btn-sm">Изменить</button>
                                                    </div>
                                                    <?php break;endif;?>
                                            <?php endforeach?>
                                        </div>
                                    </div>
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
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td><?=(double)$user_single->USDT_money?></td>
                                                <td><?=(double)$user_single->ETH_money?></td>
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
                                                    <?php if(User::canAdmin()):?>
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
            };

        if ($(_this).attr('data-type') == 'summernote') {
            data.value = el.find('div.note-editable').html();
        } else {
            data.value = el.find('input.setting, textarea.setting').val();
        }
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
    function changeUserRole(user_id, value) {
        let data = {
            user_id: user_id,
            value: value,
        };
        console.log(data);

        $.ajax({
            type: "POST",
            url: "/admin/change-user-role",
            data: data,
            success: function (msg) {
                console.log(msg);
                showToastr(msg);
            }
        })
    }
    $(document).on("change", ".user-role-change", function (e) {
        event.preventDefault();
        $(this).parent().find('a').remove();
        $(this).parent().append('<a onclick="changeUserRole('+$(this).attr("data-id")+', '+$(this).val()+')" href="#" class="btn label label-primary">Save</a>');
    });

</script>

<?php echo $this->render('../informer/modals', [
        'categories'     => $categories,
        'sub_categories' => $sub_categories,
        'tags'           => $tags
]) ?>
<?php echo $this->render('../pool/modals') ?>
<?php echo $this->render('../market/modals', ['types' => $types, 'user_marketplace' => $user_marketplace]) ?>