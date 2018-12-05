<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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

                    <table id="data_table" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>TYPE</th>
                            <th>ADDRESS WITHDRAW</th>
                            <th>Original Currency</th>
                            <th>BTC Currency(for deposit)</th>
                            <th>STATUS</th>
                            <th>Time start</th>
                            <th>Time end</th>
                            <?php if(Yii::$app->user->identity->user_role == "admin"):?>
                                <td>
                                   user id
                                </td>
                                <td>
                                    user name
                                </td>
                                <td>
                                    Manual payout
                                </td>
                            <?php endif;?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $transaction_statuses = [
                                -1=>'Возврат отмена',
                                 0=>'В выполнении',
                                1=>'Выполнена',
                                2=>'Начисленно',
                        ] ?>
                        <?php foreach ($transactions as $n=>$transaction):?>
                            <tr class="">
                                <td><?=$n?></td>
                                <td class="<?php if ($transaction->type == "deposit" ) {echo "text-danger"; }
                                else if ($transaction->type == "withdraw") {echo "text-success"; } ?>">
                                    <?=$transaction->type?>
                                </td>
                                <td><?=$transaction->user_purse?></td>
                                <td><?=(double)$transaction->amount1.' '.$transaction->currency1?></td>
                                <td><?=(double)$transaction->amount2.' '.$transaction->currency2?></td>
                                <td><span class="label <?=($transaction->status == 1 ) ? "label-primary" : "label-warning" ?>">
                                        <?=$transaction_statuses[$transaction->status == 1] ?></span>
                                </td>
                                <td><?=$transaction->date_start?></td>
                                <td><?=$transaction->date_last?></td>
                                <?php if(Yii::$app->user->identity->user_role == "admin"):?>
                                    <td>
                                        <?=$transaction->user_id?>
                                    </td>
                                    <td>
                                        <?=$transaction->user->username?>
                                    </td>
                                    <td>
                                        <?php if($transaction->type === "withdraw" &&  $transaction->status == 0):?>
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

        </div>
    </div>
</div>

