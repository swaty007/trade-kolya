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
        <h2><strong>Инвестпул</strong></h2>
    </div>
    <?php if( Yii::$app->user->identity->user_role == "admin"):?>
    <div class="col-lg-10 btn-block-style">
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#pull"><strong>Создать новый пул</strong></button>
    </div>
    <?php endif;?>
</div>

<div class="wrapper wrapper-content animated fadeIn">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel blank-panel">

                <div class="panel-heading">
                    <div class="panel-options">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Новые пулы</a></li>
                            <li><a data-toggle="tab" href="#tab-2">Активные пулы</a></li>
                            <li><a data-toggle="tab" href="#tab-3">Архивнные пулы</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-4">Мои ивестиции в пулы</a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="tab-content pull-content">

                        <div id="tab-1" class="tab-pane active">
                            <div class="row row-flex">
                                <?php foreach ($pools_new as $pool_new):?>
                                    <div class="col-lg-4 pool_block col-flex">
                                        <div class="panel panel-default pool_block">
                                            <div class="panel-heading">
                                                <strong class="pull-title"><?=$pool_new['name'];?></strong>
                                            </div>
                                            <div class="panel-body">
                                                <p class="style-pull-card pull-description"><?=$pool_new['description'];?></p>
                                                <p class="style-pull-card pull-start">Сбор средств до: <strong><?=$pool_new['date_start'];?></strong></p>
                                                <p class="style-pull-card pull-end">Окончание пула: <strong><?=$pool_new['date_end'];?></strong></p>
                                                <p class="style-pull-card pull-profit">Процент: <strong><?= $pool_new['profit']?></strong>%</p>
                                                <p class="style-pull-card pull-diversification">Количество выплат: <strong><?= $pool_new['diversification']?></strong></p>
                                                <p class="style-pull-card pull-invest">Минимальный вклад: <strong><?=(double)$pool_new['min_invest'].' '.$pool_new['invest_method'];?></strong></p>
                                                <p class="style-pull-card pull-invest">Уже в пуле всего: <strong><?php if(isset($info_pools[$pool_new['id']]['sum_invest'])) echo (double)$info_pools[$pool_new['id']]['sum_invest'].' '.$pool_new['invest_method']?></strong></p>
                                                <p class="style-pull-card pull-invest">Минимальная общая сумма: <strong><?= (double)$pool_new['min_size_invest'].' '.$pool_new['invest_method']?></strong></p>
                                                <p class="style-pull-card pull-invest">Максимальная общая сумма: <strong><?= (double)$pool_new['max_size_invest'].' '.$pool_new['invest_method']?></strong></p>
                                                <ul class="list-group">
                                                    <?php foreach ($pool_new['comments'] as $comment):?>
                                                        <li class="list-group-item">
                                                            <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                                <a onclick="deletePoolComment(<?=$comment['id']?>,this)" class="close-link pull-right" href="#">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            <?php endif;?>
                                                            <p><a class="text-info" href="#">@<?=$comment['user']['username'];?></a> <?=$comment['comment'];?></p>
                                                            <small class="block text-muted"><i class="fa fa-clock-o"></i><?=$comment['date'];?></small>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                                <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                    <?php if(isset($admin_pools[$pool_new['id']])):?>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Имя</th>
                                                                <th>Деньги</th>
                                                                <th>Возврат</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach ($admin_pools[$pool_new['id']] as $admin_pool):?>
                                                                <tr>
                                                                    <td><?=$admin_pool['user_id']?></td>
                                                                    <td><?=$admin_pool['username']?></td>
                                                                    <td><?=(double)$admin_pool['invest'].' '.$pool_new['invest_method']?></td>
                                                                    <td><button class="btn btn-danger label label-danger" type="button" onclick="returnUserMoney(<?=$admin_pool['id']?>,this)">Вернуть</button></td>
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
                                                <button onclick="investPool(<?=$pool_new['id'];?>,this)" type="button" class="btn btn-w-m btn-primary">Вложить</button>
                                                <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                    <button class="btn btn-info" type="button" onclick="editPool(<?=$pool_new['id'];?>,this)">Редактировать</button>
                                                    <button class="btn btn-danger" type="button" onclick="deletePool(<?=$pool_new['id'];?>,this)">Удалить</button>

                                                    <div class="comment_block m-t">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control value comment" placeholder="Комментарий">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button onclick="createPoolComment(<?=$pool_new['id'];?>,this)" type="button" class="btn btn-w-m btn-primary">Комментировать</button>
                                                    </div>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>

                        <div id="tab-2" class="tab-pane">
                            <div class="row row-flex">
                                <?php foreach ($pools_active as $pool_a):?>
                                    <div class="col-lg-4 pool_block col-flex">
                                        <div class="panel panel-default pool_block">
                                            <div class="panel-heading">
                                                <strong class="pull-title"><?=$pool_a['name'];?></strong>
                                            </div>
                                            <div class="panel-body">
                                                <p class="style-pull-card pull-description"><?=$pool_a['description'];?></p>
                                                <p class="style-pull-card pull-start">Сбор средств до: <strong><?=$pool_a['date_start'];?></strong></p>
                                                <p class="style-pull-card pull-end">Окончание пула: <strong><?=$pool_a['date_end'];?></strong></p>
                                                <p class="style-pull-card pull-profit">Процент: <strong><?= $pool_a['profit']?>%</strong></p>
                                                <p class="style-pull-card pull-diversification">Количество выплат: <strong><?= $pool_a['diversification']?></strong></p>
                                                <p class="style-pull-card pull-invest">Минимальный вклад: <strong><?=(double)$pool_a['min_invest'].' '.$pool_a['invest_method'];?></strong></p>
                                                <p class="style-pull-card pull-invest">Уже в пуле всего: <strong><?php if(isset($info_pools[$pool_a['id']]['sum_invest'])) echo (double)$info_pools[$pool_a['id']]['sum_invest'].' '.$pool_a['invest_method']?></strong></p>
                                                <p class="style-pull-card pull-invest">Минимальная общая сумма: <strong><?= (double)$pool_a['min_size_invest'].' '.$pool_a['invest_method']?></strong></p>
                                                <p class="style-pull-card pull-invest">Максимальная общая сумма: <strong><?= (double)$pool_a['max_size_invest'].' '.$pool_a['invest_method']?></strong></p>
                                                <ul class="list-group">
                                                    <?php foreach ($pool_a['comments'] as $comment):?>
                                                        <li class="list-group-item">
                                                            <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                                <a onclick="deletePoolComment(<?=$comment['id']?>,this)" class="close-link pull-right" href="#">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            <?php endif;?>
                                                            <p><a class="text-info" href="#">@<?=$comment['user']['username'];?></a> <?=$comment['comment'];?></p>
                                                            <small class="block text-muted"><i class="fa fa-clock-o"></i><?=$comment['date'];?></small>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                                <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                    <?php if($admin_pools[$pool_a['id']]):?>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Имя</th>
                                                            <th>Деньги</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach ($admin_pools[$pool_a['id']] as $admin_pool):?>
                                                            <tr>
                                                                <td><?=$admin_pool['user_id']?></td>
                                                                <td><?=$admin_pool['username']?></td>
                                                                <td><?=(double)$admin_pool['invest'].' '.$pool_a['invest_method']?></td>
                                                            </tr>
                                                        <?php endforeach;?>
                                                        </tbody>
                                                    </table>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            </div>
                                            <div class="panel-footer">
                                                <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                <div class="comment_block m-t">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control value comment" placeholder="Комментарий">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button onclick="createPoolComment(<?=$pool_a['id'];?>,this)" type="button" class="btn btn-w-m btn-primary">Комментировать</button>
                                                </div>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>

                        <div id="tab-3" class="tab-pane">
                            <div class="row row-flex">

                                <!--                                <pre>--><?php //var_dump($info_pools) ?><!--</pre>-->
                                <?php foreach ($pools_archive as $pool):?>
                                    <div class="col-lg-4 pool_block col-flex">
                                        <div class="panel panel-default pool_block">
                                            <div class="panel-heading">
                                                <strong class="pull-title"><?=$pool['name'];?></strong>
                                            </div>
                                            <div class="panel-body">
                                                <p class="style-pull-card pull-description"><?=$pool['description'];?></p>
                                                <p class="style-pull-card pull-start">Сбор средств до: <strong><?=$pool['date_start'];?></strong></p>
                                                <p class="style-pull-card pull-end">Окончание пула: <strong><?=$pool['date_end'];?></strong></p>
                                                <p class="style-pull-card pull-profit">Процент: <strong><?= $pool['profit']?>%</strong></p>
                                                <p class="style-pull-card pull-diversification">Количество выплат: <strong><?= $pool['diversification']?></strong></p>
                                                <p class="style-pull-card pull-invest">Минимальный вклад: <strong><?=(double)$pool['min_invest'].' '.$pool['invest_method'];?></strong></p>
                                                <p class="style-pull-card pull-invest">Уже в пуле всего: <strong><?= (double)$info_pools[$pool['id']]['sum_invest'].' '.$pool['invest_method']?></strong></p>
                                                <p class="style-pull-card pull-invest">Минимальная общая сумма: <strong><?= (double)$pool['min_size_invest'].' '.$pool['invest_method']?></strong></p>
                                                <p class="style-pull-card pull-invest">Максимальная общая сумма: <strong><?= (double)$pool['max_size_invest'].' '.$pool['invest_method']?></strong></p>
                                                <ul class="list-group">
                                                    <?php foreach ($pool['comments'] as $comment):?>
                                                        <li class="list-group-item">
                                                            <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                                <a onclick="deletePoolComment(<?=$comment['id']?>,this)" class="close-link pull-right" href="#">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            <?php endif;?>
                                                            <p><a class="text-info" href="#">@<?=$comment['user']['username'];?></a> <?=$comment['comment'];?></p>
                                                            <small class="block text-muted"><i class="fa fa-clock-o"></i><?=$comment['date'];?></small>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                                <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                    <?php if($admin_pools[$pool['id']]):?>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Имя</th>
                                                                <th>Деньги</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach ($admin_pools[$pool['id']] as $admin_pool):?>
                                                                <tr>
                                                                    <td><?=$admin_pool['user_id']?></td>
                                                                    <td><?=$admin_pool['username']?></td>
                                                                    <td><?=(double)$admin_pool['invest'].' '.$pool['invest_method']?></td>
                                                                </tr>
                                                            <?php endforeach;?>
                                                            </tbody>
                                                        </table>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            </div>

                                            <div class="panel-footer">
                                                <?php if( Yii::$app->user->identity->user_role == "admin"):?>
                                                    <button class="btn btn-danger" type="button" onclick="deletePool(<?=$pool['id'];?>,this)">Удалить</button>
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
                                                <?php endif;?>
                                            </div>

                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>

                        <div id="tab-4" class="tab-pane">
                            <div class="row">
                                <?php foreach ($user_pools as $u_pool):?>
                                <div class="col-lg-3">
                                    <div class="widget navy-bg p-xl">

                                        <h2>
                                            <?= $info_pools[$u_pool['pool_id']]['name']?>
                                        </h2>
                                        <ul class="list-unstyled m-t-md">
                                            <li>
                                                <label>Статус:</label>
                                                <?= $info_pools[$u_pool['pool_id']]['status']?>
                                            </li>
                                            <li>
                                                <label>Старт пула:</label>
                                                <?= $info_pools[$u_pool['pool_id']]['date_start']?>
                                            </li>
                                            <li>
                                                <label>Окончание пула:</label>
                                                <?= $info_pools[$u_pool['pool_id']]['date_end']?>
                                            </li>
                                            <li>
                                                <label>Ивестирование в пул:</label>
                                                <?= (double)$u_pool['invest'].' '.$info_pools[$u_pool['pool_id']]['invest_method']?>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php echo $this->render('modals') ?>
