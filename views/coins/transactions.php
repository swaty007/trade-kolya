<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use app\models\User;
$this->title = 'My Yii Application';
?>
<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><strong>Транзакции</strong></h2>
    </div>
    <div class="col-lg-10 btn-block-style">
        <button type="button" class="btn btn-w-m btn-primary" data-toggle="modal" data-target="#switchRate"><strong>Обмен средств</strong></button>
        <button type="button" class="btn btn-w-m btn-primary" data-toggle="modal" data-target="#withdraw"><strong>Вывести</strong></button>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">

    <div class="row">
        <div class="col-sm-12">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Таблица транзакций</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link binded">
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
                        <a class="close-link binded">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php \yii\widgets\Pjax::begin(); ?>
                    <table id="data_table" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
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
                    <script>
                        dataTablePajax();
                    </script>
                    <?php \yii\widgets\Pjax::end(); ?>
                </div>
            </div>

        </div>
    </div>
</div>

