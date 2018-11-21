<?php
/* @var $this yii\web\View */
?>


<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#pull"><strong>Создать новый пул</strong></button>
<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#informer-create" style="margin-bottom: 10px">Создать новость</button>
<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#market-create"><strong>Создать продукт</strong></button>




<div class="row">
<?php foreach ($admin_settings as $setting):?>
    <div class="setting_block m-t col-md-6">
        <div class="form-group row">
            <label class="col-md-3 col-form-label"><?=$setting->name?></label>
            <div class="col-md-5">
                <input type="text" class="form-control value setting" value="<?=$setting->value?>">
            </div>
            <div class="col-md-3">
                <button onclick="changeAdminSetting(<?=$setting->id?>,this)" type="button" class="btn btn-w-m btn-primary btn-sm">Изменить</button>
            </div>
        </div>

    </div>
<?php endforeach?>
</div>
    <script>
        function changeAdminSetting(id,_this) {
            event.preventDefault();
            let el = $(_this).closest('.setting_block'),
                data = {
                id: Number(id),
                value: el.find('input.setting').val(),
            };
            console.log(data);

            $.ajax({
                type: "POST",
                url: "/web/admin/change-setting",
                data: data,
                success: function (msg) {
                    console.log(msg);

                }
            })
        }
    </script>


<?php echo $this->render('../informer/modals',['categories'=>$categories,'sub_categories'=>$sub_categories,'informer_modal'=>$informer_modal,'tags'=>$tags]) ?>
<?php echo $this->render('../pool/modals') ?>
<?php echo $this->render('../market/modals',['types'=>$types,'user_marketplace'=>$user_marketplace]) ?>