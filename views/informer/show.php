<div class="wrapper wrapper-content animated fadeIn">

    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox float-e-margins">
                <div class="ibox-content article">
                    <div class="text-center article-title">
                        <span class="text-muted"><i class="fa fa-clock-o"></i> <?=$informer->date?></span>
                        <h1 class="header-title"><?=$informer->title?></h1>
                    </div>
                    <div class="text-body">
                        <?=$informer->html?>
                    </div>
                    <hr>
                    <div>
                        <a href="<?=$informer->link?>" style="display: block; margin-bottom: 10px">Ссылка на ресурс</a>
                    </div>
                    <?php if (!empty($informer->tag)) :?>
                        <div class="tags">
                            <h5 style="display: inline-block;">Tags:</h5>
                            <?php foreach ($informer->tag as $tag) :?>
                                <a class="btn btn-white btn-xs tag" type="button">
                                    <?=$tag->tag_name?>
                                </a>
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                    <?php if (!empty($informer->category)) :?>
                        <div class="categories">
                            <h5 style="display: inline-block;">Categories:</h5>
                            <?php foreach ($informer->category as $category) :?>
                                <a class="btn btn-white btn-xs" type="button">
                                    <?=$category->cat_name?>
                                </a>
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                    <div class="admins-tools">
                        <h5 style="display: inline-block;">Admins:</h5>
                        <button class="btn btn-white btn-xs" onclick="editInformer(<?=$informer->id;?>,this)" type="button">Редактировать</button>
                        <button onclick="deleteInformer(<?=$informer->id?>,this)" class="btn btn-white btn-xs" type="button">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>