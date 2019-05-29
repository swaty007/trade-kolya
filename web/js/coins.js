$(document).on('click',"#send", function(e) {
    e.preventDefault();
    let data = {
        value1: $('#money').val(),
        currency1: $('#culture_main').val()
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/coins/create-transaction",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            let answer = $('#payments');
            if (msg.msg === 'ok') {
                answer.find('.address').text(msg.result.address);
                answer.find('.status_url').attr('href',msg.result.status_url);
                answer.find('.qrcode_url').attr('src',msg.result.qrcode_url);
                answer.find('.amount1').text(msg.transaction.amount1); // in start curr
                answer.find('.amount2').text(msg.transaction.amount2); //in BTC
                answer.find('.currency1').text(msg.transaction.currency1);
                answer.find('.modal-body').toggleClass('hidden');
                answer.find('#payments_refresh').toggleClass('hidden');
            } else {
                answer.after(msg.msg);
            }
        }
    })
});
$(document).on('click','#payments_refresh', function (e) {
    e.preventDefault();
    let answer = $('#payments');
    answer.find('.modal-body').toggleClass('hidden');
    $(this).toggleClass('hidden');
});

$(document).on('click',"#send_withdraw", function(e) {
    e.preventDefault();
    let data = {
        value: $('#money_withdraw').val(),
        currency1: $('#culture_main_withdraw1').val(),
        //currency2: $('#culture_main_withdraw2').val(),
        user_purse: $('#purse_withdraw').val(),
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/coins/create-withdraw",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax();
            let answer = $('#withdraw');
            if (msg.msg === 'ok') {
                answer.find('.address').text(msg.result.user_purse);
                answer.find('.amount1').text(msg.result.amount1); // in start curr
                answer.find('.amount2').text(msg.result.amount2); //in BTC
                answer.find('.currency1').text(msg.result.currency1);
                answer.find('.modal-body').toggleClass('hidden');
                answer.find('#withdraw_refresh').toggleClass('hidden');
                answer.find('#send_withdraw').toggleClass('hidden');
            } else {
                answer.after(msg.msg);
            }
        }
    })
});
$(document).on('click','#withdraw_refresh', function (e) {
    e.preventDefault();
    let answer = $('#withdraw');
    answer.find('.modal-body').toggleClass('hidden');
    answer.find('#send_withdraw').removeClass('hidden');
    $(this).toggleClass('hidden');
});

$(document).on('click',"#switch_coin", function(e) {
    e.preventDefault();
    let data = {
        value: $('#value_switch').val(),
        currency1: $('#culture_main_switch1').val(),
        currency2: $('#culture_main_switch2').val(),
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/coins/change-rate-balance",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            closeModal($('#switchRate'));
            finishPjax('#balance_pjax');
        }
    })
});

function transactionDone(transaction_id,pjax_el) {
    event.preventDefault();
    let data = {
        transaction_id: transaction_id,
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/coins/transaction-done",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            if(pjax_el != undefined) {
                finishPjax(pjax_el);
            } else {
                finishPjax();
            }

        }
    })
}

function transactionReturn(transaction_id,pjax_el) {
    event.preventDefault();
    let data = {
        transaction_id: transaction_id,
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/coins/transaction-return",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            if(pjax_el != undefined) {
                finishPjax(pjax_el);
            } else {
                finishPjax();
            }
        }
    })
}

function copyText(_this, text) {
    if (text !== undefined) {
        var temp = $("<input>");
        $("body").append(temp);
        temp.val(text).select();
        document.execCommand("copy");
        temp.remove();
    } else {
        var temp = $("<input>");
        $("body").append(temp);
        temp.val($(_this).text()).select();
        document.execCommand("copy");
        temp.remove();
    }

    $(_this).tooltip('hide').data('bs.tooltip', false);
    $(_this).tooltip({
        trigger: 'manual',
        placement: 'top',
        title: 'Copied'
    }).tooltip('show');
    setTimeout(function () {
        $(_this).tooltip('hide');
    }, 600);
}