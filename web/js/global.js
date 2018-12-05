$('.summernote').summernote({
    tooltip: false
});

let config = {
    '.chosen-select'           : {width:"100%"},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"100%"}
};

for (let selector in config) {
    $(selector).chosen(config[selector]);
}

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
    if(typeof $ !== 'undefined') {
        if (el !== undefined) {
            $.pjax.reload({container: el});
        } else {
            $.pjax.reload({container: '#p0'});
        }
    }
}

function closeModal(modal) {
    setTimeout(function () {
        modal.modal('hide');
    }, 100);
}