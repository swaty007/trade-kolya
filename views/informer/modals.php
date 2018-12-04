<div class="modal inmodal" id="informer-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-newspaper-o modal-icon"></i>
                <h4 class="modal-title">Создать новость</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="main-label">Название</label>
                    <input id="informer_name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Описание</label>
                    <div id="informer_summernote" class="summernote"></div>
                </div>
                <div class="form-group">
                    <label class="main-label">Ссылка</label>
                    <input id="informer_link" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Картинка</label>
                    <input id="informer_file" type="file" class="form-control">
                </div>
                <div class="form-group select-style">
                    <label class="main-label">Категории</label>
                    <div class="input-group">
                        <select id="informer_category" data-placeholder="Выбор" class="chosen-select" tabindex="2">
                            <option value="0" selected disabled>Выбор</option>
                            <?php foreach ($categories as $category) :?>
                                <option value="<?=$category['id']?>"><?=$category['cat_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group select-style">
                    <label class="main-label">Подкатегории</label>
                    <div class="input-group">
                        <select id="informer_under_category"
                                data-placeholder="Выбор подкатегорий"
                                multiple
                                class="chosen-select"
                                tabindex="2">
                            <?php foreach ($sub_categories as $category) :?>
                                <option data-parent-id="<?=$category['parent_id']?>" value="<?=$category['id']?>"><?=$category['cat_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="main-label">Теги</label>
                    <input id="informer_tags" type="text" value="" data-value="<?php echo $tags?>" data-role="tagsinput" class="form-control tag_input_init"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button id="create_informer" type="button" class="btn btn-primary">Создать</button>
            </div>
        </div>
    </div>
</div>


<div class="modal inmodal" id="informer_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-paypal modal-icon"></i>
                <h4 class="modal-title">Редактировать новость</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="main-label">Название</label>
                    <input id="informer_name_req" type="text" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label class="main-label">Описание</label>
                    <div id="informer_summernote_req" class="summernote summernote_req"></div>
                </div>
                <div class="form-group">
                    <label class="main-label">Ссылка</label>
                    <input id="informer_link_req" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <img id="image_src" alt="image" class="m-t-xs img-responsive" src="" style="width: 200px; margin-left: calc(50% - 100px);">
                    </div>
                    <label class="main-label">Картинка</label>
                    <input id="informer_file_update" type="file" class="form-control">
                </div>
                <div class="form-group" id="data_1">
                    <label class="main-label">Дата Начала</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="datepicker1" type="text" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group select-style">
                    <label class="main-label">Категории</label>
                    <div class="input-group">
                        <select id="informer_category_req" data-placeholder="Выбор" class="chosen-select" tabindex="2">
                            <option value="0" selected disabled>Выбор</option>
                            <?php foreach ($categories as $category) :?>
                                <option value="<?=$category['id']?>"><?=$category['cat_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group select-style">
                    <label class="main-label">Подкатегории</label>
                    <div class="input-group">
                        <select id="informer_under_category_req"
                                data-placeholder="Выбор подкатегорий"
                                multiple
                                class="chosen-select"
                                tabindex="2">
                            <?php foreach ($sub_categories as $category) :?>
                                <option data-parent-id="<?=$category['parent_id']?>" value="<?=$category['id']?>"><?=$category['cat_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="main-label">Теги</label>
                    <input id="informer_tags_req" type="text" value="" data-value="<?php echo $tags?>" data-role="tagsinput" class="form-control tag_input_init"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button id="update_informer" data-id="" type="button" class="btn btn-primary">Обновить</button>
            </div>
        </div>
    </div>
</div>