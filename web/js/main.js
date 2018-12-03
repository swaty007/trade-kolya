/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var showCourseTimeout = [];

function showCourse(row) {
    if (!$("select", row).eq(0).val() || !$("select", row).eq(1).val()) {
        return;
    }

    $.ajax({
        type: "GET",
        url: "/cabinet/course",
        data: "marketplace_id=" + $(row).attr('data-marketplace_id') + '&symbol=' + $("select", row).eq(0).val() + $("select", row).eq(1).val(),
        dataType: "json",
        success: function (json) {
            // Draw Graph
            var min = null, max = null;
            var data = [];
            $.each(json, function (id, r) {
                if (id == 0) {
                    min = r['price'];
                    max = r['price'];
                }
                if (r['price'] > max) {
                    max = r['price'];
                }
                if (r['price'] < min) {
                    min = r['price'];
                }
                data.push([r['date'], r['price']]);
            });
            //max = parseFloat(max) + 20;
            //console.log('min=' + min + '  max=' + max);
            //max += 10;
            graph = Flotr.draw($(".graf", row).get(0), [data], {
                xaxis: {
                    mode: 'time',
                    title: 'Время'
                },
                yaxis: {
                    max: parseFloat(max) + (max - min) * 0.05,
                    min: parseFloat(min) - (max - min) * 0.05,
                    title: $("select", row).eq(1).val()

                },
                mouse: {
                    track: true
                }
            });
            //console.log('add timer^ ' + $(row).index());
            showCourseTimeout[$(row).index()] = setTimeout(function () {
                showCourse(row);
            }, 5000);
        }
    });

}

$(function () {
    $("[data-course]").each(function () {

        var row = $(this);
        $("select", this).on("change", function () {
            //console.log("change");
            if ($(row).index() in showCourseTimeout) {
                //console.log('clear timer^ ' + $(row).index());
                clearTimeout(showCourseTimeout[$(row).index()]);
            }
            showCourse(row);
        });
        /*
         var course_row = $(this);
         $("select", course_row).on("change", function(){
         var show = true;
         $("select", course_row).each(function(){if (!$(this).val()) {show = false;} })
         
         
         });
         */
    });

    // cabinet/account
    $("#BtnFindMaster").click(function () {
        $("#Masters").load('/cabinet/masters', {'marketplace_id': $("#usermarketplceform-marketplace_id").val()}, function(){
            $("#Masters [set-slave]").click(function(event){
                event.preventDefault();
                $("#usermarketplceform-slave").val($(this).attr("set-slave"));
                
            });
            $("#Masters [profit]").click(function(event){
                event.preventDefault();
                //$("#usermarketplceform-slave").val($(this).attr("set-slave"));                
            });
        });
    });


    /*
     (function () {
     var
     container = document.getElementById('container'),
     start = (new Date).getTime(),
     data, graph, offset, i;
     
     // Draw a sine curve at time t
     function animate(t) {
     
     data = [];
     offset = 2 * Math.PI * (t - start) / 10000;
     
     // Sample the sine function
     for (i = 0; i < 4 * Math.PI; i += 0.2) {
     data.push([i, Math.sin(i - offset)]);
     }
     //console.dir(data);
     
     // Draw Graph
     graph = Flotr.draw(container, [data], {
     yaxis: {
     max: 2,
     min: -2
     }
     });
     
     // Animate
     setTimeout(function () {
     animate((new Date).getTime());
     }, 50);
     }
     
     animate(start);
     })(); */
});