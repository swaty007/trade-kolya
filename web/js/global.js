let config = {
    '.chosen-select'           : {width:"100%"},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"100%"}
};


document.addEventListener('DOMContentLoaded',function () {
    $('.summernote').summernote({
        tooltip: false
    });

    for (let selector in config) {
        $(selector).chosen(config[selector]);
    }

    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1c84c6' });
});
//toast
toastr.options = {
    closeButton: true,
    debug: false,
    progressBar: true,
    preventDuplicates: false,
    positionClass: 'toast-top-right',
    onclick: null
};
toastr.options.showDuration = 300;
toastr.options.hideDuration = 1000;
toastr.options.timeOut = 5000;
toastr.options.extendedTimeOut = 1000;
toastr.options.showEasing = 'swing';
toastr.options.hideEasing = 'linear';
toastr.options.showMethod = 'fadeIn';
toastr.options.hideMethod = 'fadeOut';
//error,warning,info,success;
//toastr[shortCutFunction](msg, title);
function showToastr(msg) {
    if (msg.msg === 'ok') {
        toastr['success'](msg.status, '');
    } else if(msg.msg === 'error'){
        toastr['error'](msg.status, '');
    }
}
function finishPjax(el) {
    if(typeof $.pjax !== 'undefined') {
        if (el !== undefined) {
            $.pjax.reload({container: el});
        } else {
            $.pjax.reload({container: '#p0'});
        }
    }
}

function dataTablePajax(el) {
    if (el !== undefined) {
        el = $(el);
    } else {
        el = $('#data_table');
    }

    if(typeof $ !== 'undefined') {
        init();
    } else {
        let a = setInterval(function () {
            if (document.readyState === 'complete') {
                init();
                clearInterval(a);
            }
        },100);
    }
    function init() {
        el.DataTable({
            responsive: true,
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            },
            "language": {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }
            },
            "order": [[ 2, "desc" ]]
        });
    }
}

function closeModal(modal) {
    setTimeout(function () {
        modal.modal('hide');
    }, 100);
}

$(document).on('mouseleave',"#notification_wrap li.notification-item:not(.show)", function(e) {
    e.preventDefault();

    let _this = $(this),
        data = {
            id: Number(_this.attr('data-id'))
    };
    console.log(_this)
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/user/notification-show",
        data: data,
        success: function (msg) {
            console.log(msg);
            if (msg.msg === 'ok') {
                _this.addClass('show');
                // finishPjax('#notification_pjax');
            }
        }
    })
});