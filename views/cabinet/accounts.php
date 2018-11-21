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
        <h2>Take Profit</h2>
    </div>
    <div class="col-lg-10">
        <h3>Личный кабинет</h3>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">     
    <div class="row">
<!--        <div class="col-lg-4">-->
<!--            <div class="ibox float-e-margins">-->
<!--                <div class="ibox-title">-->
<!--                    <h5>Меню</h5>-->
<!--                    <div class="ibox-tools">-->
<!--                        <a class="collapse-link">-->
<!--                            <i class="fa fa-chevron-up"></i>-->
<!--                        </a>-->
<!--                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">-->
<!--                            <i class="fa fa-wrench"></i>-->
<!--                        </a>-->
<!--                        <ul class="dropdown-menu dropdown-user">-->
<!--                            <li><a href="#">Config option 1</a>-->
<!--                            </li>-->
<!--                            <li><a href="#">Config option 2</a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                        <a class="close-link">-->
<!--                            <i class="fa fa-times"></i>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="ibox-content">-->
<!--                    <nav>-->
<!--                        --><?php //echo $menu; ?>
<!--                    </nav>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-lg-12">
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
                    <form  action="<?php echo $delete; ?>" method="POST" id='FormAccounts'>
                        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</td>
                                    <th>Название</th>
                                    <th>Биржа</th>
                                    <th>Редактировать</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_marketplace as $value) { ?>
                                    <tr>
                                        <td><input type="checkbox" name="user_marketplace_id[]" value="<?php echo $value["user_marketplace_id"]; ?>"></td>
                                        <td><a href='<?php echo $value['open']; ?>'><?php echo $value["name"]; ?></a></td>
                                        <td><?php echo $value["marketplace_name"]; ?></td>
                                        <td><a href='<?php echo $value['edit']; ?>'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                            <!--a href='<?php echo $value['delete']; ?>'>удалить</a--></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div>
                            <a href="<?php echo $add; ?>" class="btn btn-primary">Добавить</a>
                            <a href="javascript:void(0);" onclick="if (confirm('Удалить?')) {$('#FormAccounts').submit();};" class="btn btn-danger">Удалить</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<!--        <div class="col-sm-12">-->
<!--            <div class="ibox float-e-margins">-->
<!--                <div class="ibox-title">-->
<!--                    <h5>Таблица транзакций</h5>-->
<!--                    <div class="ibox-tools">-->
<!--                        <a class="collapse-link binded">-->
<!--                            <i class="fa fa-chevron-up"></i>-->
<!--                        </a>-->
<!--                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">-->
<!--                            <i class="fa fa-wrench"></i>-->
<!--                        </a>-->
<!--                        <ul class="dropdown-menu dropdown-user">-->
<!--                            <li><a href="#">Config option 1</a>-->
<!--                            </li>-->
<!--                            <li><a href="#">Config option 2</a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                        <a class="close-link binded">-->
<!--                            <i class="fa fa-times"></i>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="ibox-content">-->
<!---->
<!--                    <table class="table">-->
<!--                        <thead>-->
<!--                        <tr>-->
<!--                            <th>#</th>-->
<!--                            <th>TXN ID</th>-->
<!--                            <th>Original Currency</th>-->
<!--                            <th>BTC Currency</th>-->
<!--                            <th>STATUS</th>-->
<!--                            <th>Time start</th>-->
<!--                            <th>Time end</th>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        --><?php //foreach ($transactions as $n=>$transaction):?>
<!--                            <tr>-->
<!--                                <td>--><?//=$n?><!--</td>-->
<!--                                <td>--><?//=$transaction->txn_id?><!--</td>-->
<!--                                <td>--><?//=$transaction->amount1.' '.$transaction->currency1?><!--</td>-->
<!--                                <td>--><?//=$transaction->amount2.' '.$transaction->currency2?><!--</td>-->
<!--                                <td>--><?//=($transaction->status == 1 ) ? "Выполнена" : "В выполнении" ?><!--</td>-->
<!--                                <td>--><?//=$transaction->date_start?><!--</td>-->
<!--                                <td>--><?//=$transaction->date_last?><!--</td>-->
<!--                            </tr>-->
<!--                        --><?php //endforeach;?>
<!--                        </tbody>-->
<!--                    </table>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>
