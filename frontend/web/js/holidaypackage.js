/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('click', '.btn_add_holiday_activity_info', function () {
    var localInfoRowHtml = $('.dv_holiday_activity_info_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
    $('.holiday_activity_info_container').append(localInfoRowHtml);
});

$(document).on('click', '.btn_add_holiday_feature_info', function () {
    var localInfoRowHtml = $('.dv_holiday_feature_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
    $('.dv_holiday_feature_info_container').append(localInfoRowHtml);
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

$(document).ready(function(){ //alert("hi")
    $('.bnt_save_holiday_package').on('click', function(){
        $('#frm_capture_holiday_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_capture_holiday_data',0);
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
    
    $('.bnt_update_holiday_package').on('click', function(){
        $('#frm_capture_holiday_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_capture_holiday_data',0);
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
    
    
    $('.bnt_save_package_itinerary').on('click', function(){
        $('#frm_capture_itinerary_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_capture_itinerary_data',0);
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
    
    $('.bnt_update_package_itinerary').on('click', function(){
        $('#frm_capture_itinerary_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_capture_itinerary_data',0);
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