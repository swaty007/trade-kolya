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
                    <label class="main-label">Доход за весь период</label>
                    <input id="pool_profit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Количество выплат</label>
                    <input id="pool_diversification" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Описание</label>
                    <textarea id="pool_description" type="text" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="main-label">Минимальная сумма</label>
                    <input id="pool_min_invest" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Минимальная сумма вкладов</label>
                    <input id="pool_min_size" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Максимальная сумма вкладов</label>
                    <input id="pool_max_size" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Тип пула</label>
                    <select class="form-control m-b main-select" id="pool_method">
                        <option value="BTC">BTC</option>
                        <option value="USDT">USDT</option>
                        <option value="ETH">ETH</option>
                    </select>
                </div>
                <div class="form-group" id="data_1">
                    <label class="main-label">Дата Начала</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="datepicker1" type="text" class="form-control" value="2018-12-01">
                    </div>
                </div>
                <div class="form-group" id="data_2">
                    <label class="main-label">Дата Окончания</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="datepicker2" type="text" class="form-control" value="2018-12-01">
                    </div>
                </div>
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
                    <label class="main-label">Доход за весь период</label>
                    <input id="pool_profit_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Количество выплат</label>
                    <input id="pool_diversification_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Описание</label>
                    <textarea id="pool_description_edit" type="text" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="main-label">Тип пула</label>
                    <select class="form-control m-b main-select" id="pool_method_edit">
                        <option value="BTC">BTC</option>
                        <option value="USDT">USDT</option>
                        <option value="ETH">ETH</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="main-label">Минимальная сумма</label>
                    <input id="pool_min_invest_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Минимальная сумма вкладов</label>
                    <input id="pool_min_size_edit" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="main-label">Максимальная сумма вкладов</label>
                    <input id="pool_max_size_edit" type="text" class="form-control">
                </div>
                <div class="form-group" id="data_1">
                    <label class="main-label">Дата Начала</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="datepicker1_edit" type="text" class="form-control" value="2018-12-01">
                    </div>
                </div>
                <div class="form-group" id="data_2">
                    <label class="main-label">Дата Окончания</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="datepicker2_edit" type="text" class="form-control" value="2018-12-01">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button id="update_pool" data-id="" type="button" class="btn btn-primary">Обновить</button>
            </div>
        </div>
    </div>
</div>

