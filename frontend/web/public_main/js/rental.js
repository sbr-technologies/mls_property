$(document).ready(function() {
    $("#property_location_geocomplete").geocomplete({
        map: "#dv_property_map_canvas",
        detailsAttribute: 'class^',
        details: "form.frm_geocomplete",
        types: ["geocode", "establishment"],
    });
    $(document).on('click', '.btn_add_rental_property_local_info', function () { 
        var curTime = Math.floor(Date.now() / 1000);
        var localInfoRowHtml = $('.dv_rental_local_info_block_template').html().replace(/curTime/g, curTime);
        $('.rental_local_info_container').append(localInfoRowHtml);

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
        var localInfoRowHtml = $('.dv_property_rental_plan_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.rental_plan_info_container').append(localInfoRowHtml);
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
    $('.bnt_save_rental_property').on('click', function(){
        $('#frm_capture_rental_property_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){ 
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_capture_rental_property_data',0);
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                    location.href = resp.redirectUrl;
                }else{
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error:function(e){
                $.loaded();
            }
        }).submit();
    });
    
    $('.bnt_update_rental_property').on('click', function(){
        $('#frm_capture_rental_property_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_capture_rental_property_data',0);
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                    location.href = resp.redirectUrl;
                }else{
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error:function(e){
                $.loaded();
            }
        }).submit();
    });
    
});
$(document).ready(function(){ //alert("hi")
    $(".datepkr").datepicker({
        language: 'pt-BR',
        format: 'dd/mm/yyyy',
        autoclose:true,
    });
    
    $(".timepicker").datetimepicker({
        format: 'LT'
    });
});