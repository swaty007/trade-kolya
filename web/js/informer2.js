$(document).on('click',"#create_informer", function(e) {
    e.preventDefault();
    let data = {
        title: $('#informer_name').val(),
        html: $('#informer_summernote').parent().find('div.note-editable').html(),
        tags: $('#informer_tags').val(),
        sub_category_ids: $('#informer_under_category').val(),
        category_id: $('#informer_category').val(),
        link: $('#informer_link').val()
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/informer/create-informer",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    });
});
$(document).on('click',"#update_informer", function(e) {
    e.preventDefault();
    let data = {
        informer_id: $('#update_informer').attr('data-id'),
        title: $('#informer_name_req').val(),
        html: $('#informer_summernote_req').parent().find('div.note-editable').html(),
        tags: $('#informer_tags_req').val(),
        sub_category_ids: $('#informer_under_category_req').val(),
        category_id: $('#informer_category_req').val(),
        link: $('#informer_link_req').val()
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/informer/update-informer",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    })
});

function editInformer(id,_this) {
    $.ajax({
        type: "POST",
        url: "/informer/get-informer",
        data: {id:id},
        success: function (msg) {
            console.log(msg);
            if (msg.msg === 'ok') {
                let informer =  msg.informer,
                    tags = informer.tag,
                    category = informer.category,
                    tag_str = "";

                $('#update_informer').attr('data-id',informer.id);
                $('#informer_name_req').val(informer.title);
                $('#informer_summernote_req').parent().find('div.note-editable').html(informer.html);
                $('#informer_link_req').val(informer.link);

                $.each(category, function (index, value) {
                    $('#informer_category_req option').each(function () {
                        if( $(this).val() == value.id) {$(this).prop("selected", true)}
                    });
                    $('#informer_under_category_req option').each(function () {
                        if( $(this).val() == value.id) {$(this).prop("selected", true)}
                    });
                });
                $('#informer_category_req,#informer_under_category_req').trigger("chosen:updated");
                filterSubCategoies('#informer_category_req','#informer_under_category_req');
                $.each(tags,function (index,value) {
                    tag_str += value.tag_name + ',';
                });

                $('#informer_tags_req').tagsinput('removeAll');
                $('#informer_tags_req').tagsinput('add', tag_str.substring(0, tag_str.length - 1));
                $('#informer_tags_req').tagsinput('refresh');

                $('#informer_edit').modal('show');

            }
        }
    })
}
function deleteInformer(id,_this) {
    let el = $(_this).closest('.pool_block'),
        data = {
            informer_id: Number(id),
        };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/informer/delete-informer",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    })
}


$(document).on('click',"#create_inf_category", function(e) {
    e.preventDefault();
    let data = {
        cat_name: $('#').val(),
        parent_id: $('#').val(), // default 0
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/informer/create-category",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    })
});
$(document).on('click',"#update_inf_category", function(e) {
    e.preventDefault();
    let data = {
        cat_id: $('#').val(),
        cat_name: $('#').val(),
        parent_id: $('#').val(),
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/informer/update-category",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    })
});
function deleteInfCategory(id,_this) {
    let el = $(_this).closest('.pool_block'),
        data = {
            cat_id: Number(id),
        };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/informer/delete-category",
        data: data,
        success: function (msg) {
            console.log(msg);
        }
    })
}

function informerPostParametrs(pagi_n) {

    let category_filter = $('#informer_filter_category').val(),
        tag_filter = $('#informer_filter_tags').val(),
        link = $('#informer_pjax_link'),
        pagination = 0,
        href = '?';

    if (pagi_n == undefined) {
        pagination = $('#pagination .active a').attr('data-page');
    } else {
        pagination = pagi_n;
    }


    if(category_filter.length > 0) {
        href += 'category='+category_filter+'&';
    }
    if(tag_filter.length > 0) {
        href += 'tag='+tag_filter+'&';
    }
    if(pagination > 0) {
        href += 'n='+pagination;
    }

    link.attr('href',href);
    link.click();
}
$('#informer_filter_category,#informer_filter_tags').on('change',function(){
    console.log(1);
    informerPostParametrs();
});
$(document).on('click','#pagination a',function () {
    // informerPostParametrs();
});

function filterSubCategoies(parent_select,children_select) {
    let selectCategory = $(parent_select).val();
    $(children_select+' option').each(function () {
        if( $(this).attr('data-parent-id') !== selectCategory) {
            $(this).prop("selected", false);
            $(this).prop("disabled", true);
        } else {
            $(this).prop("disabled", false);
        }
    });
    $(children_select).trigger("chosen:updated");
}
$('#informer_category').on('change', function () {
    filterSubCategoies('#informer_category','#informer_under_category');
});
$('#informer_category_req').on('change', function () {
    filterSubCategoies('#informer_category_req','#informer_under_category_req');
});
$(function() {
    filterSubCategoies('#informer_category','#informer_under_category');
    filterSubCategoies('#informer_category_req','#informer_under_category_req');
});


document.addEventListener("DOMContentLoaded",function () {
    let tags = $('.tag_input_init'),
        str = tags.attr('data-value'),
        items = '';

    if (str) {
        items = str.split(',');
    }

    tags.tagsinput({
        typeahead: {
            source: items,
            afterSelect: function() {
                this.$element[0].value = '';
            }
        }
    });
});