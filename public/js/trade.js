/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var showCourseTimeout = [];
var setPrice = true;
// останавливает все тайминги
function stopCouter() {
    $("[input-symbol]").val('');
    showCourseTimeout.forEach(function (item, i, arr) {
        clearTimeout(item);
        //alert( i + ": " + item + " (массив:" + arr + ")" );
    });
}

function showTrades() {
    var user_marketplace_id, symbol;

    if (!$("#currencyFrom").val() || !$("#currencyTo").val()) {
        return;
    }

    symbol = $("#currencyFrom").val() + $("#currencyTo").val(); //$("select", row).eq(0).val() + $("select", row).eq(1).val();
    user_marketplace_id = $("#user_marketplace_id").val();
    $.ajax({
        type: "GET",
        url: "/usermp/trades",
        data: "user_marketplace_id=" + user_marketplace_id + "&symbol=" + symbol,
        dataType: "json",
        success: function (json) {
            
            $("#Trades table > tbody").empty();
            
            $.each(json, function(i , r) {
                var date = new Date();
                date.setTime(r.timestamp);
                
                var t = date.getDate() + "." + (date.getMonth()+1) + "." + date.getFullYear() + " " + ( "0" + date.getHours()).substr(-2) + ":" + ( "0" + date.getMinutes()).substr(-2);                        
                //console.dir(typeof r.maker);
                $("#Trades table > tbody").append('<tr ' + (r.maker == "true" ? 'class="maker"' : 'class="makerno"') + '><td class="price">' + parseFloat(r.price).toFixed(4) + '</td><td class="right">' + parseFloat(r.quantity).toFixed(4) + '</td><td class="right">' + t + '</td></tr>');
           });
            
            showCourseTimeout['showTrades'] = setTimeout(function () {
                showTrades();
            }, 4500);
        }
    });
            
}


function showDepth() {
    var user_marketplace_id, symbol;

    if (!$("#currencyFrom").val() || !$("#currencyTo").val()) {
        return;
    }

    symbol = $("#currencyFrom").val() + $("#currencyTo").val(); //$("select", row).eq(0).val() + $("select", row).eq(1).val();
    user_marketplace_id = $("#user_marketplace_id").val();
    $.ajax({
        type: "GET",
        url: "/usermp/depth",
        data: "user_marketplace_id=" + user_marketplace_id + "&symbol=" + symbol,
        dataType: "json",
        success: function (json) {
            
            $("#depthBids table > tbody").empty();
            
            $.each(json['bids'], function(i , r) {
                $("#depthBids table > tbody").append('<tr><td class="price">' + parseFloat(i).toFixed(4) + '</td><td class="right">' + parseFloat(r).toFixed(4) + '</td><td class="right">' + parseFloat(i * r).toFixed(6) + '</td></tr>');
           });

            $("#depthAsks table > tbody").empty();
            
            $.each(json['asks'], function(i , r) {
                $("#depthAsks table > tbody").append('<tr><td class="price">' + parseFloat(i).toFixed(4) + '</td><td class="right">' + parseFloat(r).toFixed(4) + '</td><td class="right">' + parseFloat(i * r).toFixed(6) + '</td></tr>');
           });
            
            showCourseTimeout['showDepth'] = setTimeout(function () {
                showDepth();
            }, 4500);
        }
    });
            
}

function showTrade() {
    var user_marketplace_id, symbol;

    if (!$("#currencyFrom").val() || !$("#currencyTo").val()) {
        return;
    }

    symbol = $("#currencyFrom").val() + $("#currencyTo").val(); //$("select", row).eq(0).val() + $("select", row).eq(1).val();
    user_marketplace_id = $("#user_marketplace_id").val();

    $.ajax({
        type: "GET",
        url: "/usermp/ticks",
        data: "user_marketplace_id=" + user_marketplace_id + "&symbol=" + symbol,
        dataType: "json",
        success: function (json) {
            //console.dir(json);
            // Draw Graph
            /*
            var data = [];
            $.each(json, function(id , r) {
               data.push([r[0], r[1], r[2], r[3], r[4]]); 
            });
            */
           var count = parseInt($("#tradeCount").val());
           if (count > 0){
               var data = json.slice(json.length - count);
           }else{
               var data = json;
           }
           
           var i, dates = [];
           i = 0;
           $.each(data, function(id , r) {
               dates[i] = r[0];
               data[id][0]  = i;
               i++;
           });
            
            graph = Flotr.draw(document.getElementById("tradeGraf"), [data], {
                 candles: {
                    show: true,
                    candleWidth: 0.8
                },
                xaxis: {
                    noTicks: 5,
                    //mode: 'time',
                    //timeMode: 'local',
                    labelsAngle: 45,
                    //mode: 'time',
                    //title: 'Время'
                    tickFormatter: function(t){
                        var date = new Date();
                        date.setTime(dates[t]);
                        
                        return /*date.getDate() + "." + date.getMonth() + "." + date.getFullYear() + " " + */ ( "0" + date.getHours()).substr(-2) + ":" + ( "0" + date.getMinutes()).substr(-2);                        
                    }
                },
                /*
                xaxis: {
                    mode: 'time',
                    title: 'Время'
                },
                */
                /*
                yaxis: {
                    max: parseFloat(max) + (max - min) * 0.05,
                    min: parseFloat(min) - (max - min) * 0.05,
                    title: $("select", row).eq(1).val()

                },
                
                mouse: {
                    track: true
                }
                */
            });
            var p = data.pop();
            document.title = p[4] + ' ' + $("#currencyFrom").val() + ' / ' + $("#currencyTo").val() + ' TakeProfit';
            if (setPrice) {                
                $("[input-price-value]").val(p[1]);
                setPrice = false;
            }
            //console.log('add timer^ ' + $(row).index());
            showCourseTimeout['tradeGraf'] = setTimeout(function () {
                showTrade();
            }, 5000);
        }
    });
}

function userBalance(){
    var user_marketplace_id, symbol;

    if (!$("#currencyFrom").val() || !$("#currencyTo").val()) {
        return;
    }

    //symbol = $("#currencyFrom").val() + $("#currencyTo").val(); //$("select", row).eq(0).val() + $("select", row).eq(1).val();
    user_marketplace_id = $("#user_marketplace_id").val();
    $("[input-symbol]").val($("#currencyFrom").val() + $("#currencyTo").val());
    setPrice = true;
    
    $.ajax({
        type: "GET",
        url: "/usermp/balance",
        data: "user_marketplace_id=" + user_marketplace_id + "&symbol=" + symbol,
        dataType: "json",
        success: function (json) {
            var from = $("#currencyFrom").val();
            var to = $("#currencyTo").val();
            var fromValue = json[from]["available"];
            var toValue = json[to]["available"];
            $("[currency-to]").html(to);
            $("[currency-from]").html(from);
            $("[currency-to-value]").html(toValue);
            $("[currency-from-value]").html(fromValue);
            //setPrice = true;
        }
    });
    
}

function orderRestart() {
    openOrderRestart();
    orderHistoryRestart();
}

function openOrderRestart(){
    clearTimeout(showCourseTimeout['openOrder']);
    openOrder();
}

function orderHistoryRestart(){
    clearTimeout(showCourseTimeout['orderHistory']);
    orderHistory();
}

function openOrder(){
    var user_marketplace_id, symbol;
    userBalance();
    if (!$("#currencyFrom").val() || !$("#currencyTo").val()) {
        return;
    }

    symbol = $("#currencyFrom").val() + $("#currencyTo").val(); //$("select", row).eq(0).val() + $("select", row).eq(1).val();
    user_marketplace_id = $("#user_marketplace_id").val();
        $.ajax({
        type: "GET",
        url: "/usermp/openorder",
        data: "user_marketplace_id=" + user_marketplace_id + "&symbol=" + symbol,
        dataType: "json",
        success: function (json) {
            
            $("#OpenOrder table > tbody").empty();
            
            $.each(json, function(i , r) {
            var str = '<tr>';

            var date = new Date();
            date.setTime(r.time);
            var t = date.getDate() + "." + (date.getMonth()+1) + "." + date.getFullYear() + " " + ( "0" + date.getHours()).substr(-2) + ":" + ( "0" + date.getMinutes()).substr(-2);                        

            str += '<td>' + t + '</td>';
            str += '<td>' + r.symbol + '</td>';
            str += '<td>' + r.type + '</td>';
            str += '<td>' + r.side + '</td>';
            str += '<td>' + r.price + '</td>';
            str += '<td>' + r.origQty + '</td>';
            str += '<td>' + (r.origQty * r.price) + '</td>';
            str += '<td>' + r.status + '</td>';
            str += '<td><a class="btn btn-primary" href="/usermp/cancelorder?user_marketplace_id=' + user_marketplace_id + '&symbol=' + r.symbol + '&orderId=' + r.orderId + '">отмена</a></td>';
            str += '</tr>';
            
            
                $("#OpenOrder table > tbody").append(str);
           });
           
           $("#OpenOrder table > tbody a").click(function(event){
               event.preventDefault();
               $.ajax({
                    type: "GET",
                    url: $(this).attr('href'),
                    dataType: "json",
                    success: function (json) {                        
                        console.dir(json);
                        orderRestart();
                    }
                });
           });
            
            showCourseTimeout['openOrder'] = setTimeout(function () {
                openOrder();
            }, 5000);
        }
    });

}


function orderHistory(){
    var user_marketplace_id, symbol;

    if (!$("#currencyFrom").val() || !$("#currencyTo").val()) {
        return;
    }

    symbol = $("#currencyFrom").val() + $("#currencyTo").val(); //$("select", row).eq(0).val() + $("select", row).eq(1).val();
    user_marketplace_id = $("#user_marketplace_id").val();
        $.ajax({
        type: "GET",
        url: "/usermp/order",
        data: "user_marketplace_id=" + user_marketplace_id + "&symbol=" + symbol,
        dataType: "json",
        success: function (json) {
            
            $("#OrderHistory table > tbody").empty();
            
            $.each(json, function(i , r) {
            var str = '<tr>';

            var date = new Date();
            date.setTime(r.time);
            var t = date.getDate() + "." + (date.getMonth()+1) + "." + date.getFullYear() + " " + ( "0" + date.getHours()).substr(-2) + ":" + ( "0" + date.getMinutes()).substr(-2);                        

            str += '<td>' + t + '</td>';
            str += '<td>' + r.symbol + '</td>';
            str += '<td>' + r.type + '</td>';
            str += '<td>' + r.side + '</td>';
            str += '<td>' + r.price + '</td>';
            str += '<td>' + r.origQty + '</td>';
            str += '<td>' + (r.origQty * r.price) + '</td>';
            str += '<td>' + r.status + '</td>';
            str += '</tr>';
            
            
                $("#OrderHistory table > tbody").append(str);
           });
            
            showCourseTimeout['orderHistory'] = setTimeout(function () {
                orderHistory();
            }, 15000);
        }
    });

}

$(function () {
    $("[data-course]").each(function () {

        //var row = $(this);
        $("select", this).on("change", function () {
            //console.log("change");
            stopCouter();
            /*
            if ($(row).index() in showCourseTimeout) {
                //console.log('clear timer^ ' + $(row).index());
                clearTimeout(showCourseTimeout[$(row).index()]);
            }
            */
           userBalance();
            showTrade();
            showDepth();
            showTrades();
            orderHistory();
            openOrder();
            
        });
        /*
         var course_row = $(this);
         $("select", course_row).on("change", function(){
         var show = true;
         $("select", course_row).each(function(){if (!$(this).val()) {show = false;} })
         
         
         });
         */
    });
    
    
    $("[form-order]").submit(function(event){
        event.preventDefault();
        var form = $(this);
        $(".alert", form).remove();
        $.ajax({
           type: "POST",
           url: $(this).attr('action'),
           data: $(this).serialize(), // serializes the form's elements.
           dataType: "json",
           success: function(json)
           {
               if (json['success']){
                   setPrice = true;
                   $(form).prepend('<div class="alert alert-success alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Успех!</strong> Заявка принята. Номер заявки' + json.order.orderId + '</div>');
                   $(form).get(0).reset();
                   orderRestart();
               }else{
                   $(form).prepend('<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Ошибка!</strong> ' + json.message.join("<br>") + '</div>');
                   
                   //$("#exampleModalLongTitle").html("Ошибка");
                   //$("#exampleModalCenter .modal-body").html(json.message.join("<br>"));
                   //$("#exampleModalCenter").modal({'show':true});
               }
               //console.dir(json);
           }
         });
        
    });
});