function buyCopy(id,_this) {
    $('#buy_copy').attr('data-id', id);
    $('#buy_copy_modal').modal('show');
}
$(document).on('click',"#buy_copy", function(e) {
    e.preventDefault();
    let data = {
        user_marketplace_id: Number($(this).attr('data-id')),
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/cabinet/copy-buy",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax('#balance_pjax');
            finishPjax();
            closeModal($('buy_copy_modal'));
        }
    })
});