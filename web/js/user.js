$(document).on('click',"#user_update_data", function(e) {
    e.preventDefault();
    let data = {
        username: $('#user_username').val(),
        timezone: $('#user_timezone_select').val(),
        lang: $('#user_language_select').val(),
        file: $('#user_avatar')[0].files[0],//$('#informer_file').prop('files')[0],
    };
    let formData = new FormData();
    formData.append("username", data.username);
    formData.append("timezone", data.timezone);
    formData.append("lang", data.lang);
    formData.append("file", data.file);

    console.log(data);

    $.ajax({
        type: "POST",
        url: "/user/set-profile-settings",
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
    });
});