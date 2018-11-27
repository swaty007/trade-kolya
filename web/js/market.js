$(document).on('click',"#create_market", function(e) {
    e.preventDefault();
    let data = {
        title: $('#market_name').val(),
        type: $('#market_type').val(),
        description: $('#market_description').val(),
        cost: $('#market_cost').val(),
        time_action: $('#market_time_action').val(),
        count_api: $('#market_count_api').val()
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/market/create-market",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    })
});

$(document).on('click',"#update_market", function(e) {
    e.preventDefault();
    let data = {
        title: $('#market_name_edit').val(),
        type: $('#market_type_edit').val(),
        description: $('#market_description_edit').val(),
        cost: $('#market_cost_edit').val(),
        time_action: $('#market_time_action_edit').val(),
        count_api: $('#market_count_api_edit').val(),
        market_id: Number($(this).attr('data-id'))
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/market/update-market",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    })
});
function editMarket(market_id,_this) {
    let block = $(_this).parent().parent('.market_block'),
        title = block.find('.market-title').text(),
        description = block.find('.market-description span').text(),
        type = block.find('.market-type strong').text(),
        cost = block.find('.market-cost strong').text(),
        time_action = block.find('.market-end strong').text(),
        count_api = block.find('.market-count_api strong').text();

    $('#market-edit').find('#market_name_edit').val(title);
    $('#market-edit').find('#market_description_edit').val(description);
    $('#market-edit').find('#market_cost_edit').val(cost);
    $('#market-edit').find('#market_time_action_edit').val(time_action);
    $('#market-edit').find('#market_count_api_edit').val(count_api);
    $.each( $('#market_type_edit option'),function () {
        if( $(this).val() == type) {$(this).prop("selected", true)}
    });
    $('#market_type_edit').trigger("chosen:updated");
    $('#update_market').attr('data-id', market_id);
    $('#market-edit').modal('show');
}
function deleteMarket(id,_this) {
    let data = {
            market_id: Number(id),
        };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/market/delete-market",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    })
}
function buyMarket(id,_this) {

    $('#buy_market').attr('data-id', id);
    $('#market-buy').modal('show');
}
$(document).on('click',"#buy_market", function(e) {
    e.preventDefault();
    let data = {
        marketplace: $('#market_placeid_buy').val(),
        market_id: Number($(this).attr('data-id')),
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/market/buy-marketplace",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    })
});

