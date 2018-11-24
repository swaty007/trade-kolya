<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;

$this->title = 'Информер';
?>


<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2>Take Profit</h2>
    </div>
    <div class="col-lg-10">
        <h3>Информер</h3>
    </div>
    <div class="col-lg-10">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#informer-create" style="margin-bottom: 10px">Создать новость</button>

            <select id="informer_filter_category"
                    data-placeholder="Выбор категорий"
                    multiple
                    class="chosen-select"
                    tabindex="2">
                <?php foreach ($full_categories as $category) :?>
                    <option value="<?=$category['id']?>" <?php if (in_array($category['id'],$select->category)) echo 'selected' ?>><?=$category['cat_name']?></option>
                <?php endforeach;?>
            </select>
            <select id="informer_filter_tags"
                    data-placeholder="Выбор тегов"
                    multiple
                    class="chosen-select"
                    tabindex="2">
                <?php foreach ($full_tags as $tag) :?>
                    <option value="<?=$tag['id']?>" <?php if (in_array($tag['id'],$select->tag)) echo 'selected' ?>><?=$tag['tag_name']?></option>
                <?php endforeach;?>
            </select>
    </div>
</div>
<?php \yii\widgets\Pjax::begin(); ?>
<?php if (!$informers) echo 'Не найденно ни одной записи' ?>
<?php foreach ($informers as $informer) :?>
<!--    <pre>--><?php //var_dump($informer)?><!--</pre>-->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox">
                <div class="ibox-content article">
                    <div class="text-center article-title">
                        <span class="text-muted"><i class="fa fa-clock-o"></i> <?=$informer->date?></span>
                        <h1 class="header-title"><?=$informer->title?></h1>
                    </div>
                    <div class="text-body">
                        <?=$informer->html?>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 tags">
                            <h5>Tags:</h5>
                            <?php foreach ($informer->tag as $tag) :?>
                                <a href="?tag=<?=$tag->id?>" class="btn btn-white btn-xs tag" type="button">
                                    <?=$tag->tag_name?>
                                </a>
                            <?php endforeach;?>
                        </div>
                        <div class="col-md-12">
                            <h5>Categories:</h5>
                            <?php foreach ($informer->category as $category) :?>
                                <a href="?category=<?=$category->id?>" class="btn btn-white btn-xs" type="button">
                                    <?=$category->cat_name?>
                                </a>
                            <?php endforeach;?>
                        </div>
                        <div class="col-md-12">
                            <h5>Admins:</h5>
                            <button class="btn btn-white btn-xs" onclick="editInformer(<?=$informer->id;?>,this)" type="button">Редактировать</button>
                            <button onclick="deleteInformer(<?=$informer->id?>,this)" class="btn btn-white btn-xs" type="button">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
<a id="informer_pjax_link" href="/web/informer/?tag=5"></a>
<?php \yii\widgets\Pjax::end(); ?>


<?php echo $this->render('modals',['categories'=>$categories,'sub_categories'=>$sub_categories,'tags'=>$tags]) ?>







