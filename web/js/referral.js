$(document).on('click',"#referral_code_create", function(e) {
    e.preventDefault();
    let data = {
        promocode: $('#promocode_ref').val()
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/referral/create-promocode",
        data: data,
        success: function (msg) {
            console.log(msg);
            showToastr(msg);
            finishPjax('#referral_pjax');
        }
    })
});

function deletePromocode(id,_this) {
    let data = {
        promocode_id: Number(id),
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/referral/delete-promocode",
        data: data,
        success: function (msg) {
            console.log(msg);
            finishPjax('#referral_pjax');
            showToastr(msg);
        }
    })
}