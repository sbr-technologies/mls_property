$(document).ready( function(){
    $(document).on('click', '.btn_add_property_facility_info', function () {
        var localInfoRowHtml = $('.dv_property_facility_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.property_facility_info_container').append(localInfoRowHtml);
    });

    $(document).on('click', '.btn_add_property_room_facility_info', function () {
        var localInfoRowHtml = $('.dv_property_room_facility_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.property_room_facility_info_container').append(localInfoRowHtml);
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
});
