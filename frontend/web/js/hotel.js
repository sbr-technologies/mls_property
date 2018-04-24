/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){ //alert("hi")
    
    $("#property_location_geocomplete").geocomplete({
        map: "#dv_property_map_canvas",
        detailsAttribute: 'class^',
        details: "form.frm_geocomplete",
        types: ["geocode", "establishment"],
    });
    
    
    $('.bnt_save_property').on('click', function(){
        $('#frm_capture_hotel_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('basic_location_form',0);
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
    
    $('.bnt_update_hotel').on('click', function(){
        $('#frm_capture_hotel_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('basic_location_form',0);
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
    
    $('.bnt_save_room').on('click', function(){
        $('#frm_capture_room_data').ajaxForm({ 
            //display the uploaded images
            beforeSubmit:function(e){ 
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_capture_room_data',0);
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
    $('.bnt_update_room').on('click', function(){
        $('#frm_capture_room_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_capture_room_data',0);
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