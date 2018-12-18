$('#data_1 .input-group.date,#data_2 .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    format: 'yyyy-mm-dd'
});

$(document).on('click',"#create_pool", function(e) {
    e.preventDefault();
    let data = {
        profit: $('#pool_profit').val(),
        min_invest: $('#pool_min_invest').val(),
        pool_method: $('#pool_method').val(),
        name: $('#pool_name').val(),
        pool_diversification_edit: $('#pool_diversification').val(),
        description: $('#pool_description').val(),
        date_start: $('#datepicker1').val(),
        date_end: $('#datepicker2').val(),
        min_size: $('#pool_min_size').val(),
        max_size: $('#pool_max_size').val(),
        file: $("#pool_file")[0].files[0]
    };
    console.log(data);

    let formData = new FormData();

    formData.append("profit", data.profit);
    formData.append("min_invest", data.min_invest);
    formData.append("pool_method", data.pool_method);
    formData.append("name", data.name);
    formData.append("pool_diversification_edit", data.pool_diversification_edit);
    formData.append("description", data.description);
    formData.append("date_start", data.date_start);
    formData.append("date_end", data.date_end);
    formData.append("min_size", data.min_size);
    formData.append("max_size", data.max_size);
    formData.append("file", data.file);

    $.ajax({
        type: "POST",
        url: "/pool/create-pool",
        cache : false,
        processData: false,
        dataType: 'json',
        contentType: false,
        data: formData,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax();
        }
    })
});

$(document).on('click',"#update_pool", function(e) {
    e.preventDefault();
    let data = {
        profit: $('#pool_profit_edit').val(),
        min_invest: $('#pool_min_invest_edit').val(),
        pool_method: $('#pool_method_edit').val(),
        name: $('#pool_name_edit').val(),
        diversification: $('#pool_diversification_edit').val(),
        description: $('#pool_description_edit').val(),
        date_start: $('#datepicker1_edit').val(),
        date_end: $('#datepicker2_edit').val(),
        min_size: $('#pool_min_size_edit').val(),
        max_size: $('#pool_max_size_edit').val(),
        pool_id: Number($(this).attr('data-id')),
        file: $("#pool_file_update")[0].files[0],
    };

    let formData = new FormData();

    formData.append("profit", data.profit);
    formData.append("min_invest", data.min_invest);
    formData.append("pool_method", data.pool_method);
    formData.append("name", data.name);
    formData.append("pool_diversification_edit", data.pool_diversification_edit);
    formData.append("description", data.description);
    formData.append("date_start", data.date_start);
    formData.append("date_end", data.date_end);
    formData.append("min_size", data.min_size);
    formData.append("max_size", data.max_size);
    formData.append("file", data.file);

    console.log(data);

    $.ajax({
        type: "POST",
        url: "/pool/update-pool",
        cache : false,
        processData: false,
        dataType: 'json',
        contentType: false,
        data: formData,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax();
        }
    })
});


function editPool(id,_this) {
    let block = $(_this).parent().parent('.pool_block'),
        title = block.find('.pull-title').text(),
        description = block.find('.pull-description').text(),
        start = block.find('.pull-start strong').text(),
        diversification = block.find('.pull-diversification strong').text(),
        end = block.find('.pull-end strong').text(),
        min_value = block.find('.pull-invest strong').text(),
        profit = block.find('.pull-profit strong').text(),
        src = block.find('.pool_image').attr('src');

    $('#pull-edit').find('#pool_profit_edit').val(profit);
    $('#pull-edit').find('#pool_name_edit').val(title);
    $('#pull-edit').find('#pool_description_edit').val(description);
    $('#pull-edit').find('#pool_diversification_edit').val(diversification);
    $('#pull-edit').find('#datepicker1_edit').val(start);
    $('#pull-edit').find('#datepicker2_edit').val(end);
    $('#pull-edit').find('#pool_min_invest_edit').val(min_value);
    $('#update_pool').attr('data-id', id);
    $('#image_pool_src').attr('src', src);
    $('#pull-edit').modal('show');
}

function deletePool(id,_this) {
    let el = $(_this).closest('.pool_block.col-flex'),
        data = {
            pool_id: Number(id),
        };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/pool/delete-pool",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            if (msg.msg === 'ok') {
                finishPjax();
            }
        }
    })
}

function investPool(id,_this) {
    let el = $(_this).closest('.pool_block'),
        data = {
            pool_id: Number(id),
            value: el.find('input.value').val()
        };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/pool/create-user-pool",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax('#balance_pjax');
            finishPjax();
        }
    })
}



function returnUserMoney(id,_this) {
    let el = $(_this).closest('.pool_block'),
        data = {
            user_pool_id: Number(id),
        };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/pool/return-user-money",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax();
        }
    })
}

function createPoolComment(id,_this) {
    let el = $(_this).closest('.comment_block'),
        data = {
            pool_id: Number(id),
            comment: el.find('input.comment').val()
        };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/pool/create-comment",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax();
        }
    })
}

function deletePoolComment(id,_this) {
    event.preventDefault();
    let el = $(_this).closest('.list-group-item'),
        data = {
            comment_id: Number(id),
        };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/pool/delete-comment",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            if (msg.msg === "ok") {
                el.remove();
            }
        }
    })
}