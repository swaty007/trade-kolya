
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
                                    <th>Сортировка</th>
                                    <th>Статус</th>
                                    <th>Дата окончания</th>
                                    <th>Редактировать</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_marketplace as $value) { ?>
                                    <tr>
                                        <td><input type="checkbox" name="user_marketplace_id[]" value="<?php echo $value["user_marketplace_id"]; ?>"></td>
                                        <td>
                                            <?php if ($value["user_market_id"] == 0) :?>
                                            <p><?php echo $value["name"]; ?></p>
                                            <?php else :?>
                                                <a href='<?php echo $value['open']?>'><?php echo $value["name"]; ?></a>
                                            <?php endif;?>
                                        </td>
                                        <td><?php echo $value["marketplace_name"]; ?></td>
                                        <td><?php echo $value["order"]; ?></td>
                                        <td>
                                            <?php if ($value["user_market_id"] == 0) :?>
                                                Не активный
                                            <?php else :?>
                                                Активный
                                            <?php endif;?>
                                        </td>
                                        <td><?php echo $value["market_date_end"]; ?></td>
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
    </div>
</div>

