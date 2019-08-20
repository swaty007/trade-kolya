<div class="modal inmodal" id="pull" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-paypal modal-icon"></i>
                <h4 class="modal-title">Создать пулл</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="main-label">Название</label>
                    <input id="pool_name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Описание</label>
                    <textarea id="pool_description" type="text" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="main-label">Полное описание</label>
                    <textarea id="pool_full_description" type="text" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="main-label">Тип</label>
                    <select id="pool_type" class="form-control">
                        <option value="API">API</option>
                        <option value="direct">прямой</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="main-label">Форма</label>
                    <select id="pool_form" class="form-control">
                        <option value="crypto">Крипто</option>
                        <option value="forex">FOREX TRADING</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="main-label">Тип пула валюты</label>
                    <select class="form-control m-b main-select" id="pool_method">
                        <option value="BTC">BTC</option>
                        <option value="USDT">USDT</option>
                        <option value="ETH">ETH</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="main-label">Тип процентирования</label>
                    <select class="form-control m-b main-select" id="type_percent">
                        <option value="fixed">фиксированный</option>
                        <option value="float" selected>плавающий</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="main-label">Процент выплаты</label>
                    <input id="pool_profit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Процент выплаты (плавающий)</label>
                    <input id="pool_float_profit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Количество выплат</label>
                    <input id="pool_diversification" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Процент рефералу</label>
                    <input id="pool_referral" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Минимальная сумма вклада в пулл</label>
                    <input id="pool_min_invest" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Временной промежуток работы пулла</label>
                    <select id="pool_month" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="main-label">Картинка</label>
                    <input id="pool_file" type="file" class="form-control">
                </div>
<!--                <div class="form-group">-->
<!--                    <label class="main-label">Минимальная сумма вкладов</label>-->
<!--                    <input id="pool_min_size" type="text" class="form-control">-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label class="main-label">Максимальная сумма вкладов</label>-->
<!--                    <input id="pool_max_size" type="text" class="form-control">-->
<!--                </div>-->
<!--                <div class="form-group" id="data_1">-->
<!--                    <label class="main-label">Дата Начала</label>-->
<!--                    <div class="input-group date">-->
<!--                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="datepicker1" type="text" class="form-control" value="2018-12-01">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="form-group" id="data_2">-->
<!--                    <label class="main-label">Дата Окончания</label>-->
<!--                    <div class="input-group date">-->
<!--                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="datepicker2" type="text" class="form-control" value="2018-12-01">-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button id="create_pool" type="button" class="btn btn-primary">Создать</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="pull-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-paypal modal-icon"></i>
                <h4 class="modal-title">Создать пулл</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="main-label">Название</label>
                    <input id="pool_name_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Описание</label>
                    <textarea id="pool_description_edit" type="text" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="main-label">Полное описание</label>
                    <textarea id="pool_full_description_edit" type="text" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="main-label">Тип</label>
                    <select id="pool_type_edit" class="form-control">
                        <option value="API">API</option>
                        <option value="direct">прямой</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="main-label">Форма</label>
                    <select id="pool_form_edit" class="form-control">
                        <option value="crypto">Крипто</option>
                        <option value="forex">FOREX TRADING</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="main-label">Тип пула валюты</label>
                    <select class="form-control m-b main-select" id="pool_method_edit">
                        <option value="BTC">BTC</option>
                        <option value="USDT">USDT</option>
                        <option value="ETH">ETH</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="main-label">Тип процентирования</label>
                    <select class="form-control m-b main-select" id="type_percent_edit">
                        <option value="fixed">фиксированный</option>
                        <option value="float">плавающий</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="main-label">Процент выплаты</label>
                    <input id="pool_profit_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Процент выплаты (плавающий)</label>
                    <input id="pool_float_profit_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Количество выплат</label>
                    <input id="pool_diversification_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Процент рефералу</label>
                    <input id="pool_referral_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Минимальная сумма вклада в пулл</label>
                    <input id="pool_min_invest_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Временной промежуток работы пулла</label>
                    <select id="pool_month_edit" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <img id="image_pool_src" alt="image" class="m-t-xs img-responsive" src="" style="width: 200px; margin-left: calc(50% - 100px);">
                    </div>
                    <label class="main-label">Картинка</label>
                    <input id="pool_file_update" type="file" class="form-control">
                </div>
<!--                <div class="form-group">-->
<!--                    <label class="main-label">Минимальная сумма вкладов</label>-->
<!--                    <input id="pool_min_size_edit" type="text" class="form-control">-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label class="main-label">Максимальная сумма вкладов</label>-->
<!--                    <input id="pool_max_size_edit" type="text" class="form-control">-->
<!--                </div>-->
<!--                <div class="form-group" id="data_1_edit">-->
<!--                    <label class="main-label">Дата Начала</label>-->
<!--                    <div class="input-group date">-->
<!--                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="datepicker1_edit" type="text" class="form-control" value="2018-12-01">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="form-group" id="data_2_edit">-->
<!--                    <label class="main-label">Дата Окончания</label>-->
<!--                    <div class="input-group date">-->
<!--                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="datepicker2_edit" type="text" class="form-control" value="2018-12-01">-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button id="update_pool" data-id="" type="button" class="btn btn-primary">Обновить</button>
            </div>
        </div>
    </div>
</div>

