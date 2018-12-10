
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
                    <?php \yii\widgets\Pjax::begin(); ?>
                    <form  action="<?= $delete; ?>" method="POST" id='FormAccounts'>
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
                                    <th>Активировать</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_marketplace as $value) { ?>
                                    <tr>
                                        <td><input type="checkbox" name="user_marketplace_id[]" value="<?= $value["user_marketplace_id"]; ?>"></td>
                                        <td>
                                            <?php if ($value["user_market_id"] == 0) :?>
                                            <p><?= $value["name"]; ?></p>
                                            <?php else :?>
                                                <a href='<?= $value['open']?>'><?= $value["name"]; ?></a>
                                            <?php endif;?>
                                        </td>
                                        <td><?= $value["marketplace_name"]; ?></td>
                                        <td><?= $value["order"]; ?></td>
                                        <td>
                                            <?php if ($value["user_market_id"] == 0) :?>
                                                Не активный
                                            <?php else :?>
                                                Активный
                                            <?php endif;?>
                                        </td>
                                        <td><?php echo $value["market_date_end"]; ?></td>
                                        <td><a href='<?= $value['edit']; ?>'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                            <!--a href='<?= $value['delete']; ?>'>удалить</a--></td>
                                        <td>
                                            <a class="btn btn-success label label-success" onclick="marketToApi(<?= $value['user_marketplace_id']; ?>)">Активировать</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div>
                            <a href="<?= $add; ?>" class="btn btn-primary">Добавить</a>
                            <a href="javascript:void(0);" onclick="if (confirm('Удалить?')) {$('#FormAccounts').submit();};" class="btn btn-danger">Удалить</a>
                        </div>
                    </form>
                    <?php \yii\widgets\Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="market-to-api" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-newspaper-o modal-icon"></i>
                <h4 class="modal-title">Купить апи</h4>
            </div>
            <div class="modal-body">
                <div class="form-group select-style">
                    <label class="main-label">Выбрать апи</label>
                    <div class="input-group">
                        <select id="market_placeid_buy"
                                data-placeholder="Выбор"
                                class="chosen-select"
                                tabindex="2">
                            <?php foreach ($markets_user as $market): ?>
                                <option value="<?= $market["id"]?>">
                                    <?= $market["count_api"]; ?>  <?= $market["title"]; ?> <?= $market["description"]; ?> <?= $market["time_action"]; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button id="market_to_api" type="button" data-id="" class="btn btn-primary">Купить</button>
            </div>
        </div>
    </div>
</div>