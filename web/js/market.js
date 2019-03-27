$(document).on('click',"#create_market", function(e) {
    e.preventDefault();
    let data = {
        title: $('#market_name').val(),
        type: $('#market_type').val(),
        description: $('#market_description').val(),
        cost: $('#market_cost').val(),
        time_action: $('#market_time_action').val(),
        count_api: $('#market_count_api').val(),
        file: $("#market_file")[0].files[0]
    };

    let formData = new FormData();

    formData.append("title", data.title);
    formData.append("type", data.type);
    formData.append("description", data.description);
    formData.append("cost", data.cost);
    formData.append("time_action", data.time_action);
    formData.append("count_api", data.count_api);
    formData.append("file", data.file);

    console.log(data);

    $.ajax({
        type: "POST",
        url: "/market/create-market",
        cache : false,
        processData: false,
        dataType: 'json',
        contentType: false,
        data: formData,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax();
            closeModal($('#market-create'));
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
        market_id: Number($(this).attr('data-id')),
        file: $("#market_file_update")[0].files[0]
    };

    let formData = new FormData();
    formData.append("title", data.title);
    formData.append("type", data.type);
    formData.append("description", data.description);
    formData.append("cost", data.cost);
    formData.append("time_action", data.time_action);
    formData.append("count_api", data.count_api);
    formData.append("market_id", data.market_id);
    formData.append("file", data.file);

    console.log(data);

    $.ajax({
        type: "POST",
        url: "/market/update-market",
        cache : false,
        processData: false,
        dataType: 'json',
        contentType: false,
        data: formData,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax();
            closeModal($('#market-edit'));
        }
    })
});
function editMarket(market_id,_this) {
    let block = $(_this).parent().parent(),
        title = block.parent().find('.market-title').text(),
        description = block.find('.market-description').text(),
        type = block.find('.market-type').text(),
        cost = block.find('.market-cost').text(),
        time_action = block.find('.market-end').text(),
        count_api = block.find('.market-count_api').text(),
        src = block.parent().find('.market_image').attr('src');


    $('#market-edit').find('#market_name_edit').val(title);
    $('#market-edit').find('#market_description_edit').val(description);
    $('#market-edit').find('#market_cost_edit').val(cost);
    $('#market-edit').find('#market_time_action_edit').val(time_action);
    $('#market-edit').find('#market_count_api_edit').val(count_api);
    $('#image_market_src').attr('src', src);

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
            finishPjax();
            showToastr(msg);
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
        market_id: Number($(this).attr('data-id')),
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/market/buy-marketplace",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax('#balance_pjax');
            finishPjax();
            closeModal($('#market-buy'));
        }
    })
});
$(document).on('click',"#market_to_api", function(e) {
    e.preventDefault();
    let data = {
        marketplace: Number($(this).attr('data-id')),
        user_market_id: $('#market_placeid_buy').val(),
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/market/marketplace-to-api",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax();
            closeModal($('#market-to-api'));
        }
    })
});

function marketToApi(id,_this) {
    $('#market_to_api').attr('data-id', id);
    $('#market-to-api').modal('show');
}