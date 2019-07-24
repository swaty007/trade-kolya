<?php
use yii\helpers\Html;
$this->title = 'Информер';
?>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2><strong><?=$this->title?></strong></h2>
    </div>
    <div class="col-lg-10">
        <?php if (Yii::$app->user->identity->user_role == "admin") : ?>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#informer-create"
                    style="margin-bottom: 10px"><strong>Создать новость</strong></button>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($informer)): ?>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?php echo $this->render('show',
        [
            'informer' => $informer,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'tags' => $tags
        ]
    ) ?>
    <?php \yii\widgets\Pjax::end(); ?>
<?php else : ?>
    <div class="wrapper wrapper-content animated fadeIn">

        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
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
                                        <ul>
                                        <?php foreach ($categories as $main_category) :?>
                                            <li>
                                                <a onclick="informerCatFilter(<?=$main_category->id?>)"><?= $main_category->cat_name ?></a>
                                                <ul>
                                                    <?php foreach ($sub_categories as $sub_category) :?>
                                                    <?php if ($sub_category->parent_id == $main_category->id):?>
                                                    <li><a onclick="informerCatFilter(<?=$sub_category->id?>)"><?= $sub_category->cat_name ?></a></li>
                                                    <? endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>

                                            </li>
                                        <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="col-lg-12">
                                        <select id="informer_filter_tags"
                                                data-placeholder="Выбор тегов"
                                                multiple
                                                class="chosen-select"
                                                tabindex="2">
                                            <?php foreach ($full_tags as $tag) : ?>
                                                <option value="<?= $tag['id'] ?>" <?php if (isset($select->tag)) if (in_array($tag['id'], $select->tag)) echo 'selected' ?>><?= $tag['tag_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Информация</h5>
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
                                        <h3><?php echo $information_title->value ?></h3>
                                        <p><?php echo $information_text->value ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <?php \yii\widgets\Pjax::begin(); ?>
                <?php if (!$informers) echo 'Не найденно ни одной записи' ?>
                <?php foreach (array_chunk($informers, 2) as $row) : ?>
                    <div class="row">
                        <?php foreach ($row as $informer) : ?>
                            <div class="col-lg-6">
                                <div href="?id=<?= $informer->id ?>" class="contact-box" data-id="<?= $informer->id ?>">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="text-center">
                                                <img alt="image"
                                                     class="m-t-xs img-responsive"
                                                     src="<?= $informer->src ? $informer->src : '/image/tp_image.png' ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <h3 class="clip"><strong><?= $informer->title ?></strong></h3>
                                            <p><i class="fa fa-clock-o"></i> <?= substr($informer->date, 0, 10) ?></p>
                                            <div class="informer-html"><?= $informer->html ?></div>
                                            <?php if (!empty($informer->tag)) : ?>
                                                <div class="tags">
                                                    <h5 style="display: inline-block;">Tags:</h5>
                                                    <?php foreach ($informer->tag as $tag) : ?>
                                                        <a href="?tag=<?= $tag->id ?>" class="btn btn-white btn-xs tag"
                                                           type="button">
                                                            <?= $tag->tag_name ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <?php \yii\widgets\Pjax::end(); ?>
            </div>

        </div>
    </div>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?php if ($informers_count > 10): ?>
        <div class="paging_simple_numbers">
            <ul id="pagination" class="pagination">
                <li class="paginate_button page-item previous <?php if ($pagination == 0) {
                    echo 'active';
                } ?>">
                    <a <?php if ($pagination == 0) : ?>
                        disabled
                    <?php else : ?>
                        onclick="informerPostParametrs(<?= $pagination - 1 ?>)"
                    <?php endif; ?>
                            class="page-link">Previous</a>
                </li>
                <?php
                $i = 0;
                while ($i <= $informers_count - 1):
                    $i++;
                    if (!($i % 10) == 1):; ?>

                        <li class="paginate_button page-item <?php if ($pagination == ($i / 10) - 1) {
                            echo 'active';
                        } ?>">
                            <a onclick="informerPostParametrs(<?= ($i / 10) - 1; ?>)"
                               data-page="<?= ($i / 10) - 1; ?>" class="page-link"><?= $i / 10; ?></a>
                        </li>
                    <?php endif; endwhile; ?>
                <li class="paginate_button page-item <?php if ($pagination == ceil($i / 10) - 1) {
                    echo 'active';
                } ?>">
                    <a onclick="informerPostParametrs(<?= ceil($i / 10) - 1 ?>)"
                       data-page="<?= ceil($i / 10) - 1 ?>" class="page-link"><?= ceil($i / 10); ?></a>
                </li>
                <li class="paginate_button page-item next <?php if ($pagination == ceil($i / 10) - 1) {
                    echo 'active';
                } ?>">
                    <a <?php if ($pagination == ceil($i / 10) - 1) : ?>
                        disabled
                    <?php else : ?>
                        onclick="informerPostParametrs(<?= $pagination + 1 ?>)"
                    <?php endif; ?>
                            class="page-link">Next</a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
    <a id="informer_pjax_link" class="hidden" href="/informer/?tag=5"></a>
    <script>
        finishPjax('#p0');
    </script>
    <?php \yii\widgets\Pjax::end(); ?>
<?php endif; ?>

<?php echo $this->render('modals', ['categories' => $categories, 'sub_categories' => $sub_categories, 'tags' => $tags]) ?>