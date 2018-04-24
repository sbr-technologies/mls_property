
$(document).on('click', '.btn_add_holiday_feature_info', function () {
    var localInfoRowHtml = $('.dv_holiday_feature_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
    $('.dv_holiday_feature_info_container').append(localInfoRowHtml);
});


$(document).on('click', '.btn_add_holiday_activity_info', function () {
    var localInfoRowHtml = $('.dv_holiday_activity_info_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
    $('.holiday_activity_info_container').append(localInfoRowHtml);
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

