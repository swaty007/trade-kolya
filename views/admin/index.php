<?php

$this->title = 'Админка';
?>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><strong>Админка</strong></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Возможности</h5>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#pull"><strong>Создать новый пул</strong></button>
                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#informer-create"><strong>Создать новость</strong></button>
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#market-create"><strong>Создать продукт</strong></button>
                        </div>
                        <?php foreach ($admin_settings as $setting) :?>
                        <div class="col-lg-12">
                            <div class="setting_block m-t col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label"><?=$setting->name?></label>
                                    <div class="col-md-5">
                                        <?php if($setting->id == 3) :?>
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
                        <div class="col-lg-12">
                            <table id="data_table" class="table table-striped table-bordered table-hover dataTables-example dataTable dtr-inline">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NICKNAME</th>
                                    <th>USER_ROLE</th>
                                    <th>EMAIL</th>
                                    <th>USDT_money</th>
                                    <th>ETH_money</th>
                                    <th>BTC_money</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $user):?>
                                    <tr class="">
                                        <td><?=$user->id?></td>
                                        <td><?=$user->username?></td>
                                        <td><?=$user->user_role?></td>
                                        <td><?=$user->email?></td>
                                        <td><?=(double)$user->USDT_money?></td>
                                        <td><?=(double)$user->ETH_money?></td>
                                        <td><?=(double)$user->BTC_money?></td>
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