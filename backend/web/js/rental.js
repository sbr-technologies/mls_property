$(document).on('click', '.btn_add_property_local_info', function () {
    var curTime = Math.floor(Date.now() / 1000);
    var localInfoRowHtml = $('.dv_local_info_block_template').html().replace(/curTime/g,curTime);
    $('.property_local_info_container').append(localInfoRowHtml);

    $(".geocomplete_local_info_" + curTime).geocomplete({
        types: ["geocode", "establishment"],
    }).bind("geocode:result", function(event, result){
        console.log(result);
        var lat = result.geometry.location.lat(), lng = result.geometry.location.lng();
        $('.lat_' + curTime).val(lat);
        $('.lng_' + curTime).val(lng);
    });
});

$(document).on('click', '.btn_add_rental_plan_info', function () {
    var localInfoRowHtml = $('.dv_rental_plan_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
    $('.property_rental_plan_container').append(localInfoRowHtml);
});

$(document).on('click', '.btn_add_rental_feature_info', function () {
    var localInfoRowHtml = $('.dv_rental_feature_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
    $('.dv_rental_feature_info_container').append(localInfoRowHtml);
});

$(document).on('click', '.delete_child', function () {
    var that = $(this), thatItem = that.closest('.item');
    if (thatItem.hasClass('new') || confirm("Are you sure you want to delete this row?")) {
        if(that.hasClass('new')){
            thatItem.remove();
        }else{
            thatItem.find('.hidin_child_id').val('1');
            thatItem.hide();
        }
    }
});

$( document ).ready(function() {
    $(".datepkr").datepicker({
        language: 'pt-BR',
        format: 'dd/mm/yyyy',
        autoclose:true,
        startDate: new Date(),
//        endDate:new Date(),
        //defaultViewDate :today,
    });

    $(".timepicker").datetimepicker({
        format: 'LT'
    });
});

