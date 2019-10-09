document.addEventListener("DOMContentLoaded", function () {
    $('#data_1 .input-group.date,#data_2 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
});
$(document).on('click',"#create_pool", function(e) {
    e.preventDefault();
    let data = {
        profit: $('#pool_profit').val(),
        min_invest: $('#pool_min_invest').val(),
        pool_method: $('#pool_method').val(),
        name: $('#pool_name').val(),
        diversification: $('#pool_diversification').val(),
        description: $('#pool_description').val(),

        type: $('#pool_type').val(),
        form: $('#pool_form').val(),
        float_profit: $('#pool_float_profit').val(),
        full_description: $('#pool_full_description').val(),
        month: $('#pool_month').val(),
        type_percent: $('#type_percent').val(),
        referral_percent: $('#pool_referral').val(),
        // date_start: $('#datepicker1').val(),
        // date_end: $('#datepicker2').val(),
        // min_size: $('#pool_min_size').val(),
        // max_size: $('#pool_max_size').val(),
        file: $("#pool_file")[0].files[0]
    };
    console.log(data);

    let formData = new FormData();

    formData.append("type", data.type);
    formData.append("form", data.form);
    formData.append("type_percent", data.type_percent);
    formData.append("profit", data.profit);
    formData.append("float_profit", data.float_profit);
    formData.append("min_invest", data.min_invest);
    formData.append("pool_method", data.pool_method);
    formData.append("referral_percent", data.referral_percent);
    formData.append("name", data.name);
    formData.append("diversification", data.diversification);
    formData.append("description", data.description);
    formData.append("full_description", data.full_description);
    formData.append("month", data.month);
    // formData.append("date_start", data.date_start);
    // formData.append("date_end", data.date_end);
    // formData.append("min_size", data.min_size);
    // formData.append("max_size", data.max_size);
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
            closeModal($("#pull"));
            console.log(msg);
            showToastr(msg);
            finishPjax();
        }
    });
});

$(document).on('click',"#update_pool", function(e) {
    e.preventDefault();
    let data = {
        profit: $('#pool_profit_edit').val(),
        min_invest: $('#pool_min_invest_edit').val(),
        pool_method: $('#pool_method_edit').val(),
        name: $('#pool_name_edit').val(),
        pool_diversification_edit: $('#pool_diversification_edit').val(),
        description: $('#pool_description_edit').val(),
        // date_start: $('#datepicker1_edit').val(),
        // date_end: $('#datepicker2_edit').val(),
        // min_size: $('#pool_min_size_edit').val(),
        // max_size: $('#pool_max_size_edit').val(),
        pool_id: Number($(this).attr('data-id')),
        file: $("#pool_file_update")[0].files[0],

        type: $('#pool_type_edit').val(),
        form: $('#pool_form_edit').val(),
        float_profit: $('#pool_float_profit_edit').val(),
        full_description: $('#pool_full_description_edit').val(),
        month: $('#pool_month_edit').val(),
        type_percent: $('#type_percent_edit').val(),
        referral_percent: $('#pool_referral_edit').val(),
    };

    let formData = new FormData();

    formData.append("profit", data.profit);
    formData.append("min_invest", data.min_invest);
    formData.append("pool_method", data.pool_method);
    formData.append("name", data.name);
    formData.append("diversification_edit", data.pool_diversification_edit);
    formData.append("description", data.description);
    // formData.append("date_start", data.date_start);
    // formData.append("date_end", data.date_end);
    // formData.append("min_size", data.min_size);
    // formData.append("max_size", data.max_size);
    formData.append("file", data.file);
    formData.append("pool_id", data.pool_id);

    formData.append("type", data.pool_id);
    formData.append("form", data.pool_id);
    formData.append("float_profit", data.pool_id);
    formData.append("full_description", data.pool_id);
    formData.append("month", data.pool_id);
    formData.append("type_percent", data.pool_id);
    formData.append("referral_percent", data.pool_id);



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
            closeModal($('#pull-edit'));
            finishPjax();
        }
    })
});


function editPool(id,_this) {
    let block = $(_this).closest('.pool_block'),
        title = block.find('.pull-title').text(),
        description = block.find('.pull-description').text(),
        // start = block.find('.pull-start strong').text(),
        diversification = block.find('.pull-diversification strong').text(),
        // end = block.find('.pull-end strong').text(),
        min_value = block.find('.pull-invest strong').text(),
        // min_value_invest = block.find('.pull-invest-min strong').text(),
        // max_value_invest = block.find('.pull-invest-max strong').text(),
        profit = block.find('.pull-profit strong').text(),
        src = block.find('.pool_image').attr('src'),

        type = block.find('.pull-type').attr('data-value'),
        form = block.find('.pull-form strong').text(),
        float_profit = block.find('.pull-float_profit strong').text(),
        full_description = block.find('.pull-full_description strong').text(),
        month = block.find('.pull-period strong').text(),
        type_percent = block.find('.pull-type_percent').attr('data-value'),
        referral_percent = block.find('.pull-referral strong').text();

    $('#pull-edit').find('#pool_profit_edit').val(profit);
    $('#pull-edit').find('#pool_name_edit').val(title);
    $('#pull-edit').find('#pool_description_edit').val(description);
    $('#pull-edit').find('#pool_diversification_edit').val(diversification);
    // $('#pull-edit').find('#datepicker1_edit').val(start);
    // $('#pull-edit').find('#datepicker2_edit').val(end);
    $('#pull-edit').find('#pool_min_invest_edit').val(min_value);
    // $('#pull-edit').find('#pool_min_size_edit').val(min_value_invest);
    // $('#pull-edit').find('#pool_max_size_edit').val(max_value_invest);
    $('#update_pool').attr('data-id', id);
    $('#image_pool_src').attr('src', src);


    $('#pool_type_edit').val(type);
    $('#pool_form_edit').val(form);
    $('#pool_float_profit_edit').val(float_profit);
    $('#pool_full_description_edit').val(full_description);
    $('#pool_month_edit').val(month);
    if (type_percent !== "float") {
        $('#type_percent_edit').parent('div').hide();
    } else {
        $('#type_percent_edit').parent('div').show();
        $('#type_percent_edit').val(type_percent);
    }

    $('#pool_referral_edit').val(referral_percent);

    $('#pull-edit').modal('show');
}

$(document).on('change', "#type_percent_edit, #type_percent", function (e) {
    var type_percent = $(this).val();
    if (type_percent !== "float") {
        $('#pool_float_profit, #pool_float_profit_edit').parent('div').hide();
    } else {
        $('#pool_float_profit, #pool_float_profit_edit').parent('div').show();
    }
});

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
function confirmPoolApi(id,_this) {
    let el = $(_this).closest('.pool_block'),
        data = {
            user_pool_id: Number(id),
        };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/pool/confirm-pool-api",
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