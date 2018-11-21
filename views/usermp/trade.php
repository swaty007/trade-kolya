<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Trade';
?>
<style type="text/css">
    #tradeGraf {
        width : 100%;
        height: 384px;
        margin: 8px auto;
        /*background-color: lightskyblue;*/

    }

    #depthBids table tr td, #depthAsks table tr td, #Trades table tr td{
        padding: 2px;
    }
    .right{
        text-align: right;
    }


    #depthBids, #depthAsks, #Trades {
        overflow-x: hidden;
        overflow-y: auto;
        height: 300px;
    }

    #depthBids .price {
        color: #FF6600;
    }

    #depthAsks .price {
        color: #0e0;
    }

    .makerno {
        color: #0e0;
    }

    .maker {
        color: #FF6600;
    }

    .UserBalans {
        font-size: 12px;
        padding: 8px 16px;;
        font-weight: normal;
    }
</style>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2>Take Profit</h2>
    </div>
    <div class="col-lg-10">
        <h3><?php echo $name; ?></h3>
    </div>
    <div class="col-lg-12">
        <div class="dropdown" style="margin-bottom: 20px">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Меню <span class="caret"></span></button>
            <div class="dropdown-menu">
                <?php echo $menu; ?>
            </div>
        </div> 
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">     
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Настройки</h5>
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
                    <div data-course data-marketplace_id="" class="row">
                        <input type="hidden" name="user_marketplace_id" id="user_marketplace_id" value="<?php echo $user_marketplace_id; ?>">
                        <div class="currency col-lg-6" style="display: inline-block;">
                            <div class="row">
                                <label class="col-lg-3">Валютная пара: </label>
                                <div class="col-lg-9">
                                    <select id="Symbol" class="select2-dropdown">
                                        <option value="">Валютная пара</option>
                                <?php foreach ($symbols as $symbol) { ?>
                                    <option value="<?php echo $symbol['name']; ?>" tradingview='<?php echo $symbol['tradingview']; ?>'><?php echo $symbol['name']; ?></option>
                                <?php } ?>
                            </select>
                                </div>
                            </div>
                        </div>
                        <div class="" style="display: none;margin-left: 50px;">
                            <label>Кол. на графике</label>
                            <select id="tradeCount">
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="500">500</option>
                                <option value="0" selected="selected">Все</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Статистика</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <style>
                    .legend .block {
                        border:1px solid #666;
                        border-radius: 4px; 
                        text-align: center; 
                        padding: 5px 0; 
                        margin: 5px
                    }
                    
                    .legend .header {
                        line-height: 24px;
                        white-space: nowrap;
                        background: white;
                        width: 100%;
                        overflow: hidden;
                        display: block;
                    }
                    .legend .value {
                        font-weight: bold;
                        line-height: 24px; 
                        height: 24px;
                    }
                </style>
                <div class="ibox-content">
                    <div class="row legend">
                        <div class='col-lg-2 block'>
                            <div class='header'>Symbol</div>
                            <div class='value' id='legend_symbol'></div>
                        </div>
                        <div class='col-lg-2 block'>
                            <div class='header'>последняя цена</div>
                            <div class='value' id='legend_lastPrice'></div>
                        </div>
                        <div class='col-lg-2 block'>
                            <div class='header'>изменение цены (%)</div>
                            <div class='value' id='legend_percentChange'></div>
                        </div>
                        <div class='col-lg-2 block'>
                            <div class='header'>Лучшая цена продажи</div>
                            <div class='value' id='legend_lowestAsk'></div>
                        </div>
                        <div class='col-lg-2 block'>
                            <div class='header'>Лучшая цена покупки</div>
                            <div class='value' id='legend_highestBid'></div>
                        </div>
                        <div class='col-lg-2 block'>
                            <div class='header'>Объем торгов в базовой валюте</div>
                            <div class='value' id='legend_baseVolume'></div>
                        </div>
                        <div class='col-lg-2 block'>
                            <div class='header'>Объем торгов в квотируемой валюте</div>
                            <div class='value' id='legend_quoteVolume'></div>
                        </div>
                        <div class='col-lg-2 block'>
                            <div class='header'>Высшая цена за сутки</div>
                            <div class='value' id='legend_high24hr'></div>
                        </div>
                        <div class='col-lg-2 block'>
                            <div class='header'>Низшая цена за сутки</div>
                            <div class='value' id='legend_low24hr'></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>График tradingview</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div id="tradingview_graf" style='height: 500px;'></div>


                </div>
            </div>
        </div>

        <!-- TradingView Widget BEGIN -->
            <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
            <script type="text/javascript">
                            var tradingview_market_name = '<?php echo $tradingview_market_name; ?>';
                                  function StartTradingView() {
                                      symbol = $("#Symbol option:selected").attr("tradingview").replace(/[^a-zA-Z]/gi,'');
                                      console.log(tradingview_market_name + ':' + symbol);
                                      new TradingView.widget(
                                              {
                                                  "autosize": true,
                                                  "symbol": tradingview_market_name + ':' + symbol,
                                                  "interval": "1",
                                                  "timezone": "Etc/UTC",
                                                  "theme": "Light",
                                                  "style": "1",
                                                  "locale": "ru",
                                                  "toolbar_bg": "#f1f3f6",
                                                  "enable_publishing": false,
                                                  "hide_side_toolbar": false,
                                                  "container_id": "tradingview_graf"
                                              }
                                      );
                                  }

                                  function StopTradingView(){
                                      $("#tradingview_graf").html('');
                                  }

            </script>

        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Cпрос</h5>
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
                    <div id="depthBids">
                        <table class="table table-bordered table-hover" style="margin:0;padding: 0;font-size: 10px;">
                            <thead>
                                <tr>
                                    <td>Цена</td>
                                    <td>Кол</td>
                                    <td>Сумма</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Предложения</h5>
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
                    <div id="depthAsks">
                        <table class="table table-bordered table-hover" style="margin:0;padding: 0;font-size: 10px;">
                            <thead>
                                <tr>
                                    <td>Цена</td>
                                    <td>Кол</td>
                                    <td>Сумма</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>     
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>График</h5>
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
                    <div id="tradeGraf" style=""></div>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>ТАБ</h5>
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
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#limit">Limit</a></li>
                            <li><a data-toggle="tab" href="#market">Market</a></li>
                            <li><a data-toggle="tab" href="#StopLimit">Stop-Limit</a></li>
                        </ul>
                        <div class="row">
                            <div class="col-sm-6 UserBalans">
                                <label>Купить <span currency-from></span></label>
                                <label class="pull-right"><span currency-to></span> баланс <span currency-to-value></span></label>
                            </div>
                            <div class="col-sm-6 UserBalans">
                                <label>Продать <span currency-from></span></label>
                                <label class="pull-right"><span currency-from></span> баланс <span currency-from-value></span></label>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div id="limit" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form action="<?php echo $urlBuy; ?>" form-order>
                                            <input type="hidden" name="symbol" value="" input-symbol />
                                            <div class="form-group">
                                                <label for="count">Цена:</label>
                                                <input type="number" name="price" step="0.0001" min="0" class="form-control" id="count" required input-price-value>
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Количество:</label>
                                                <input type="number" name="quantity" step="0.01" min="0" class="form-control" id="count" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Сумма:</label>
                                                <input type="text" name="summ" step="0.01" min="0" class="form-control" id="count">
                                            </div>
                                            <button type="submit" button-submit class="btn btn-success">Купить</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-6">
                                        <form action="<?php echo $urlSell; ?>" form-order>
                                            <input type="hidden" name="symbol" value="" input-symbol />
                                            <div class="form-group">
                                                <label for="count">Цена:</label>
                                                <input type="number" name="price" step="0.0001" min="0" class="form-control" id="count" required input-price-value>
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Количество:</label>
                                                <input type="number" name="quantity" step="0.01" min="0" class="form-control" id="count" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Сумма:</label>
                                                <input type="text" name="summ" step="0.01" min="0" class="form-control" id="count">
                                            </div>
                                            <button type="submit" button-submit class="btn btn-info">Продать</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div id="market" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form action="<?php echo $urlBuy; ?>" form-order>
                                            <input type="hidden" name="symbol" value="" input-symbol />
                                            <div class="form-group">
                                                <label for="count">Цена:</label>
                                                <input type="text" name="type" value="MARKET" class="form-control" required readonly="readonly">
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Количество:</label>
                                                <input type="number" name="quantity" step="0.01" min="0" class="form-control" id="count" required>
                                            </div>
                                            <button type="submit" button-submit class="btn btn-success">Купить</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-6">
                                        <form action="<?php echo $urlSell; ?>" form-order>
                                            <input type="hidden" name="symbol" value="" input-symbol />
                                            <div class="form-group">
                                                <label for="count">Цена:</label>
                                                <input type="text" name="type" value="MARKET" class="form-control" required readonly="readonly">
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Количество:</label>
                                                <input type="number" name="quantity" step="0.01" min="0" class="form-control" id="count" required>
                                            </div>
                                            <button type="submit" button-submit class="btn btn-info">Продать</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="StopLimit" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form action="<?php echo $urlBuy; ?>" form-order>
                                            <input type="hidden" name="symbol" value="" input-symbol />
                                            <div class="form-group">
                                                <label for="count">Стоп:</label>
                                                <input type="number" name="stopPrice" step="0.0001" min="0" class="form-control" id="count" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Цена:</label>
                                                <input type="number" name="price" step="0.0001" min="0" class="form-control" id="count" required input-price-value>
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Количество:</label>
                                                <input type="number" name="quantity" step="0.01" min="0" class="form-control" id="count" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Сумма:</label>
                                                <input type="text" name="summ" step="0.01" min="0" class="form-control" id="count">
                                            </div>
                                            <button type="submit" button-submit class="btn btn-success">Купить</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-6">
                                        <form action="<?php echo $urlSell; ?>" form-order>
                                            <input type="hidden" name="symbol" value="" input-symbol />
                                            <div class="form-group">
                                                <label for="count">Стоп:</label>
                                                <input type="number" name="stopPrice" step="0.0001" min="0" class="form-control" id="count" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Цена:</label>
                                                <input type="number" name="price" step="0.0001" min="0" class="form-control" id="count" required input-price-value>
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Количество:</label>
                                                <input type="number" name="quantity" step="0.01" min="0" class="form-control" id="count" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="count">Сумма:</label>
                                                <input type="text" name="summ" step="0.01" min="0" class="form-control" id="count">
                                            </div>
                                            <button type="submit" button-submit class="btn btn-info">Продать</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Сделки</h5>
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
                    <div id="Trades"> 
                        <table class="table table-bordered table-hover" style="margin:0;padding: 0;font-size: 10px;">
                            <thead>
                                <tr>
                                    <td>Цена</td>
                                    <td>Кол</td>
                                    <td>Время</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>     
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Открытые ордера</h5>
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
                    <div id="OpenOrder">
                        <table class="table table-bordered table-hover" style="margin:0;padding: 0;font-size: 10px;">
                            <thead>
                                <tr>
                                    <td>Дата</td>
                                    <td>Валюта</td>
                                    <td>Тип</td>
                                    <td>Операция</td>
                                    <td>Цена</td>
                                    <td>Количество</td>
                                    <td>Сумма</td>
                                    <td>Статус</td>
                                    <td>Отмена</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Сделки</h5>
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
                    <div id="OrderHistory">
                        <table class="table table-bordered table-hover" style="margin:0;padding: 0;font-size: 10px;">
                            <thead>
                                <tr>
                                    <td>Дата</td>
                                    <td>Валюта</td>
                                    <td>Тип</td>
                                    <td>Операция</td>
                                    <td>Цена</td>
                                    <td>Количество</td>
                                    <td>Сумма</td>
                                    <td>Статус</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle">Modal title</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!--button type="button" class="btn btn-primary">Save changes</button-->
            </div>
        </div>
    </div>
</div>