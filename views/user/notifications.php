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
                    <script>
                        dataTablePajax();
                    </script>
                    <?php \yii\widgets\Pjax::end(); ?>
                </div>
            </div>

        </div>
    </div>
</div>

