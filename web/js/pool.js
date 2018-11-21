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
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/web/pool/create-pool",
        data: data,
        success: function (msg) {
            console.log(msg);
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
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/web/pool/update-pool",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    })
});

let a = setInterval(function () {
    if (document.readyState === 'complete') {
        $('#data_table').DataTable( {
            "order": [[ 2, "desc" ]]
        } );
        $('#data_table').show('slide',200);
        clearInterval(a);
    }
},100);

function editPool(id,_this) {
    let block = $(_this).parent().parent('.pool_block'),
        title = block.find('.pull-title').text(),
        description = block.find('.pull-description').text(),
        start = block.find('.pull-start strong').text(),
        diversification = block.find('.pull-diversification strong').text(),
        end = block.find('.pull-end strong').text(),
        min_value = block.find('.pull-invest strong').text(),
        profit = block.find('.pull-profit strong').text();

    $('#pull-edit').find('#pool_profit_edit').val(profit);
    $('#pull-edit').find('#pool_name_edit').val(title);
    $('#pull-edit').find('#pool_description_edit').val(description);
    $('#pull-edit').find('#pool_diversification_edit').val(diversification);
    $('#pull-edit').find('#datepicker1_edit').val(start);
    $('#pull-edit').find('#datepicker2_edit').val(end);
    $('#pull-edit').find('#pool_min_invest_edit').val(min_value);
    $('#update_pool').attr('data-id', id);
    $('#pull-edit').modal('show');
}

function deletePool(id,_this) {
    let el = $(_this).closest('.pool_block'),
        data = {
            pool_id: Number(id),
        };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/web/pool/delete-pool",
        data: data,
        success: function (msg) {
            console.log(msg);
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
        url: "/web/pool/create-user-pool",
        data: data,
        success: function (msg) {
            console.log(msg);
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
        url: "/web/pool/return-user-money",
        data: data,
        success: function (msg) {
            console.log(msg);
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
        url: "/web/pool/create-comment",
        data: data,
        success: function (msg) {
            console.log(msg);
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
        url: "/web/pool/delete-comment",
        data: data,
        success: function (msg) {
            console.log(msg);
            if (msg.msg === "ok") {
                el.remove();
            }
        }
    })
}