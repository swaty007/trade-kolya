<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'Инвестпул';

use app\models\User;
use yii\helpers\Url;
?>
<div class="row wrapper border-bottom grey-bg">
    <div class="col-lg-10">
        <h2><strong>Инвестпул</strong></h2>
    </div>
    <?php if( User::canAdmin()):?>
        <div class="col-lg-10 btn-block-style">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#pull"><strong>Создать новый пул</strong></button>
        </div>
    <?php endif;?>
</div>

    <div class="wrapper wrapper-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default pool_block">
                            <div class="panel-heading">
                                <strong class="pull-title"><?=$pool['name'];?> <?=$pool['form'] == 'Крипто' ? '': 'FOREX TRADING';?></strong>
                            </div>
                                <div class="panel-body">
                                    <img src="<?= $pool['src'] ? $pool['src'] : '/image/tp_image.png' ?>" alt="pool" class="pool_image">
                                    <p class="style-pull-card pull-type" data-value="<?=$pool['type'];?>">Тип: <strong><?=$pool['type'] == 'API' ? 'API' : 'прямой';?></strong></p>
                                    <!--                                                <p class="style-pull-card pull-form">Форма: --><?//=$pool['form'] == 'Крипто' ? '': 'FOREX TRADING';?><!--</p>-->
                                    <p class="style-pull-card pull-form">Тип пула валюты: <strong><?=$pool['invest_method'];?></strong></p>
                                    <p class="style-pull-card pull-type_percent" data-value="<?=$pool['type_percent'];?>">Тип процентирования: <strong><?=$pool['type_percent'] == 'fixed' ? 'фиксированный' : 'плавающий';?></strong></p>
                                    <p class="style-pull-card pull-period">Работа пулла: <strong><?=$pool['period'];?></strong> мес.</p>
                                    <p class="style-pull-card pull-profit">Процент выплаты: <strong><?=$pool['profit'];?></strong>%</p>
                                    <?php if ($pool['type_percent'] == 'float') :?>
                                        <p class="style-pull-card pull-float_profit">Процент выплаты (плавающий): <strong><?=$pool['float_profit'];?></strong>%</p>
                                    <?php endif;?>
                                    <p class="style-pull-card pull-description">Описание: <strong><?=$pool['description'];?></strong></p>
                                    <p class="style-pull-card pull-full_description">Полное описание: <strong><?=$pool['full_description'];?></strong></p>
                                    <p class="style-pull-card pull-diversification">Количество выплат: <strong><?= $pool['diversification']?></strong></p>
                                    <p class="style-pull-card pull-invest">Минимальный вклад: <strong><?=(double)$pool['min_invest'];?></strong> <?=$pool['invest_method']?></p>
                                    <p class="style-pull-card pull-referral">Процент рефералу: <strong><?=$pool['referral_percent'];?>%</strong></p>
                                    <!--                                                <p class="style-pull-card">Уже в пуле всего: <strong>--><?php //if(isset($info_pools[$pool['id']]['sum_invest'])) echo (double)$info_pools[$pool['id']]['sum_invest'].' '.$pool['invest_method']?><!--</strong></p>-->
                                    <!--                                                <p class="style-pull-card pull-invest-min">Минимальная общая сумма: <strong>--><?//= (double)$pool['min_size_invest']?><!--</strong>--><?//=$pool['invest_method']?><!--</p>-->
                                    <!--                                                <p class="style-pull-card pull-invest-max">Максимальная общая сумма: <strong>--><?//= (double)$pool['max_size_invest']?><!--</strong>--><?//=$pool['invest_method']?><!--</p>-->
                                    <ul class="list-group">
                                        <?php foreach ($pool['comments'] as $comment):?>
                                            <li class="list-group-item">
                                                <?php if( User::canAdmin()):?>
                                                    <a onclick="deletePoolComment(<?=$comment['id']?>,this)" class="close-link pull-right" href="#">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                <?php endif;?>
                                                <p><a class="text-info" href="#">@<?=$comment['user']['username'];?></a> <?=$comment['comment'];?></p>
                                                <small class="block text-muted"><i class="fa fa-clock-o"></i><?=$comment['date'];?></small>
                                            </li>
                                        <?php endforeach;?>
                                    </ul>
                                    <?php if( User::canAdmin()):?>
                                        <div class="comment_block m-t">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control value comment" placeholder="Комментарий">
                                                    </div>
                                                </div>
                                            </div>
                                            <button onclick="createPoolComment(<?=$pool['id'];?>,this)" type="button" class="btn btn-w-m btn-primary">Комментировать</button>
                                        </div>
                                        <?php if(isset($admin_pools[$pool['id']])):?>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Имя</th>
                                                    <th>Деньги</th>
                                                    <th>Возврат</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($admin_pools[$pool['id']] as $admin_pool):?>
                                                    <tr>
                                                        <td><?=$admin_pool['user_id']?></td>
                                                        <td><?=$admin_pool['username']?></td>
                                                        <td><?=(double)$admin_pool['invest'].' '.$pool['invest_method']?></td>
                                                        <td><button class="btn btn-danger label label-danger" type="button" onclick="event.preventDefault();returnUserMoney(<?=$admin_pool['id']?>,this)">Вернуть</button></td>
                                                        <?php if ($pool['type'] === "direct"):?>
                                                            <?php if ((int)$admin_pool['status'] == \app\models\UserPools::STATUS_DEPOSIT):?>

                                                            <?php elseif((int)$admin_pool['status'] == \app\models\UserPools::STATUS_WITHDRAW):?>
                                                                <td>Выплачен</td>
                                                            <?php endif;?>
                                                        <?php elseif ($pool['type'] === "API" && (int)$admin_pool['status'] == \app\models\UserPools::STATUS_WAIT_ACTIVATION):?>
                                                            <td><button class="btn btn-primary label label-primary" type="button" onclick="event.preventDefault();confirmPoolApi(<?=$admin_pool['id']?>,this)">Подвердить API</button></td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach;?>
                                                </tbody>
                                            </table>
                                        <?php endif;?>
                                    <?php endif;?>
                                </div>
                           <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control value" placeholder="Введите сумму">
                                        </div>
                                    </div>
                                </div>
                                <button onclick="investPool(<?=$pool['id'];?>,this)" type="button" class="btn btn-w-m btn-primary">Вложить</button>
                               <?php if( User::canAdmin()):?>
                                <button class="btn btn-info" type="button" onclick="editPool(<?=$pool['id'];?>,this)">Редактировать</button>
                                <button class="btn btn-danger" type="button" onclick="deletePool(<?=$pool['id'];?>,this)">Удалить</button>
                               <?php endif;?>

                           </div>
                </div>

            </div>
        </div>
    </div>


<?php echo $this->render('modals') ?>