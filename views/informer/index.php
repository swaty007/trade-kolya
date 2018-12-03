<?php
use yii\helpers\Html;

$this->title = 'Информер';
?>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><strong>Информер</strong></h2>
    </div>
    <div class="col-lg-10">
        <?php if (Yii::$app->user->identity->user_role == "admin") :?>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#informer-create" style="margin-bottom: 10px"><strong>Создать новость</strong></button>
        <?php endif;?>
    </div>
</div>
<?php \yii\widgets\Pjax::begin(); ?>

<div class="wrapper wrapper-content animated fadeIn">

    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Фильтры</h5>
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
                    <div class="row">
                        <div class="col-lg-12" style="margin-bottom: 10px">
                            <select id="informer_filter_category"
                                    data-placeholder="Выбор категорий"
                                    multiple
                                    class="chosen-select"
                                    tabindex="2"
                                    >
                                <?php foreach ($full_categories as $category) :?>
                                    <option value="<?=$category['id']?>" <?php if (isset($select->category)) if (in_array($category['id'],$select->category)) echo 'selected' ?>><?=$category['cat_name']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <select id="informer_filter_tags"
                                    data-placeholder="Выбор тегов"
                                    multiple
                                    class="chosen-select"
                                    tabindex="2">
                                <?php foreach ($full_tags as $tag) :?>
                                    <option value="<?=$tag['id']?>" <?php if (isset($select->tag)) if (in_array($tag['id'],$select->tag)) echo 'selected' ?>><?=$tag['tag_name']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <?php if (!$informers) echo 'Не найденно ни одной записи' ?>
            <?php foreach (array_chunk($informers, 2) as $row) :?>
            <div class="row">
                <?php foreach ($row as $informer) :?>
                    <div class="col-lg-6">
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

                                    <?php if (!empty($informer->tag)) :?>
                                        <div class="col-md-12 tags">
                                            <h5>Tags:</h5>
                                            <?php foreach ($informer->tag as $tag) :?>
                                                <a href="?tag=<?=$tag->id?>" class="btn btn-white btn-xs tag" type="button">
                                                    <?=$tag->tag_name?>
                                                </a>
                                            <?php endforeach;?>
                                        </div>
                                    <?php endif;?>
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
                <?php endforeach;?>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<?php if($informers_count > 10):?>
    <div class="paging_simple_numbers">
        <ul id="pagination" class="pagination">
            <li class="paginate_button page-item previous <?php if($pagination == 0){echo 'active';} ?>" >
                <a <?php if($pagination == ceil($i/10)-1) :?>
                    disabled
                <?php else :?>
                    onclick="informerPostParametrs(<?=$pagination - 1?>)"
                <?php endif;?>
                        class="page-link" >Previous</a>
            </li>
            <?php
            $i=0;
            while ($i <= $informers_count):
                $i++; if(!($i%10) == 1):;?>

                <li class="paginate_button page-item <?php if ($pagination == ($i/10)-1) {echo 'active';}?>">
                    <a onclick="informerPostParametrs(<?=($i/10)-1;?>)" data-page="<?=($i/10)-1;?>" class="page-link"><?=$i/10;?></a>
                </li>
            <?php endif; endwhile; ?>
            <li class="paginate_button page-item <?php if ($pagination == ceil($i/10)-1) {echo 'active';}?>">
                <a onclick="informerPostParametrs(<?=$pagination+1?>)" data-page="<?=$pagination+1?>" class="page-link"><?=ceil($i/10);?></a>
            </li>
            <li class="paginate_button page-item next <?php if($pagination == ceil($i/10)-1){echo 'active';} ?>">
                <a <?php if($pagination == ceil($i/10)-1) :?>
                    disabled
                <?php else :?>
                    onclick="informerPostParametrs(<?=$pagination+1?>)"
                <?php endif;?>
                        class="page-link">Next</a>
            </li>
        </ul>
    </div>
<?php endif;?>

<a id="informer_pjax_link" class="hidden" href="/informer/?tag=5"></a>
<?php \yii\widgets\Pjax::end(); ?>
<?php echo $this->render('modals',['categories'=>$categories,'sub_categories'=>$sub_categories,'tags'=>$tags]) ?>







