<div class="modal inmodal" id="market-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-newspaper-o modal-icon"></i>
                <h4 class="modal-title">Создать продукт</h4>
            </div>
            <div class="modal-body">
                <div class="form-group select-style">
                    <label class="main-label">Тип продукта</label>
                    <div class="input-group">
                        <select id="market_type" data-placeholder="Выбор" class="chosen-select" tabindex="2">
                            <option value="0" selected disabled>Выбор</option>
                            <?php foreach ($types as $type) :?>
                                <option value="<?=$type?>"><?=$type?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="main-label">Название</label>
                    <input id="market_name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Описание</label>
                    <textarea id="market_description" type="text" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="main-label">Стоимость</label>
                    <input id="market_cost" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Количество дней</label>
                    <input id="market_time_action" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Количество апи</label>
                    <input id="market_count_api" type="text" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button id="create_market" type="button" class="btn btn-primary">Создать</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="market-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-newspaper-o modal-icon"></i>
                <h4 class="modal-title">Редактировать продукт</h4>
            </div>
            <div class="modal-body">
                <div class="form-group select-style">
                    <label class="main-label">Тип продукта</label>
                    <div class="input-group">
                        <select id="market_type_edit" data-placeholder="Выбор" class="chosen-select" tabindex="2">
                            <option value="0" selected disabled>Выбор</option>
                            <?php foreach ($types as $type) :?>
                                <option value="<?=$type?>">
                                    <?=$type?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="main-label">Название</label>
                    <input id="market_name_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Описание</label>
                    <textarea id="market_description_edit" type="text" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="main-label">Стоимость</label>
                    <input id="market_cost_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Количество дней</label>
                    <input id="market_time_action_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Количество апи</label>
                    <input id="market_count_api_edit" type="text" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button id="update_market" type="button" data-id="" class="btn btn-primary">Обновить</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="market-buy" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-newspaper-o modal-icon"></i>
                <h4 class="modal-title">Купить продукт</h4>
            </div>
            <div class="modal-body">
                <div class="form-group select-style">
                    <p>
                        Вы уверены что хотите купить?
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button id="buy_market" type="button" data-id="" class="btn btn-primary">Купить</button>
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
                                tabindex="2"
                                multiple>
                            <?php foreach ($user_marketplace as $value): ?>
                                <option value="<?= $value["user_marketplace_id"]?>">
                                    <?php echo $value["marketplace_name"]; ?>
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