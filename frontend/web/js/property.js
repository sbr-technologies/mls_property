/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){ //alert("hi")
    $(".add-required div.form-group").addClass("required");
    $(".datepkr").datepicker({
        language: 'pt-BR',
        format: 'dd/mm/yyyy',
        autoclose:true,
    });
    
    $(".timepicker").datetimepicker({
        format: 'LT'
    });
    
//    $("#property_location_geocomplete").geocomplete({
//        map: "#dv_property_map_canvas",
//        detailsAttribute: 'class^',
//        details: "form.frm_geocomplete",
//        types: ["geocode", "establishment"],
//    });
    
    $('body').on('click', '.bnt_create_apartment', function(){
        $('#frm_create_apartment').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(response){
                $.loaded();
                if (response.status == true){
                    swal(response.message);
                    $('#mls_bs_modal_lg').modal('hide');
                    $.pjax.reload({container: '#apartment_pjax_container'});
                }else{
                    swal(first(response.errors));
                }
            },
            error:function(e){
                $.loaded();
            }
        }).submit();
    });
    
    $('.bnt_save_property').on('click', function(){ 
        $('#save_incomplete').val(0);
        $('#frm_capture_property_data').ajaxForm({
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
                }else if(resp.success == false && resp.message){
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 5000);
                }else{
                    $('.failmsgdiv').html(first(resp.errors));
                    $('#failMsgDiv').show('slow');
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 5000);
                }
            },
            error:function(e){
                $.loaded();
            }
        }).submit();
    });
    
    $('.bnt_save_incomplete_property').on('click', function(){ 
        $('#save_incomplete').val(1);
        $('#frm_capture_property_data').ajaxForm({
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
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error:function(e){
                $.loaded();
            }
        }).submit();
    });
    $('.bnt_update_property').on('click', function(){
        $('#frm_capture_property_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_capture_property_data',0);
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                    location.href = resp.redirectUrl;
                }else{
                    alert(JSON.stringify(resp));
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error:function(e){
                $.loaded();
            }
        }).submit();
    });
    
    $('.bnt_copy_property').on('click', function(){ 
        $('#frm_capture_property_data').ajaxForm({
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
    
    var propertyId  =   '';
    if($('#id').val() != ''){
        var propertyId  =   $('#id').val(); 
    }
    var selectedVal =   '';
    var categoryId  =   $('#property_category_id').val();
    var marketStatus =  $('#market_status').val();
    showHideDiv(categoryId); 
    showHideSoldDiv(marketStatus);
});

function showHideDiv(selectedVal){ 
    if(selectedVal == 1){
        $('#salePropertyDiv').hide('slow');
        $('#serviceOtherDiv').show('slow');
        priceForList(selectedVal);
        serviceForList(selectedVal);
        otherForList(selectedVal);
        contactTermList(selectedVal);
        $('#contactTermDiv').show('slow');
    }else if(selectedVal == 2){
        $('#salePropertyDiv').show('slow');
        $('#serviceOtherDiv').hide('slow');
        $('#contactTermDiv').hide('slow');
        $('#priceForDiv').html('');
    }else if(selectedVal == 3){
        $('#salePropertyDiv').hide('slow');
        $('#serviceOtherDiv').show('slow');
        priceForList(selectedVal);
        serviceForList(selectedVal);
        otherForList(selectedVal);
        contactTermList(selectedVal);
        $('#contactTermDiv').show('slow');
//        $('#marketStatusDiv').show('slow');
    }else{
        $('#salePropertyDiv').hide('slow');
        $('#serviceOtherDiv').hide('slow');
        $('#contactTermDiv').hide('slow');
    }
}
function showHideSoldDiv(selectedVal){ 
    if(selectedVal == 'Sold'){
        $('#soldDataDiv').show('slow');
    }else{
        $('#soldDataDiv').hide('slow');
        $("#property-sold_price").val('');
        $("#property-solddate").val('');
    }
}
function priceForList(selectedVal) {
    if(selectedVal != ''){
        listingUrl	=   'price-for-list';
        listingUrl	+=  '?selected_id='+selectedVal;
        $.ajax({
            url: listingUrl,
            type: 'get',
            cache: false,
            success: function (res) {
                $('#priceForDiv').html(res);
            },
            error: function (xhr, textStatus, thrownError) {
            }
        });
    }else{
        $('#priceForDiv').html('');
    }
}
function serviceForList(selectedVal) {
    if(selectedVal != ''){
        listingUrl	=   'service-for-list';
        listingUrl	+=  '?selected_id='+selectedVal;
        $.ajax({
            url: listingUrl,
            type: 'get',
            cache: false,
            success: function (res) {
                $('#serviceForDiv').html(res);
            },
            error: function (xhr, textStatus, thrownError) {
            }
        });
    }else{
        $('#serviceForDiv').html('');
    }
}
function otherForList(selectedVal) {
    if(selectedVal != ''){
        listingUrl	=   'other-for-list';
        listingUrl	+=  '?selected_id='+selectedVal;
        $.ajax({
            url: listingUrl,
            type: 'get',
            cache: false,
            success: function (res) {
                $('#otherForDiv').html(res);
            },
            error: function (xhr, textStatus, thrownError) {
            }
        });
    }else{
        $('#otherForDiv').html('');
    }
}
function contactTermList(selectedVal) {
    if(selectedVal != ''){
        listingUrl	=   'contact-term-list';
        listingUrl	+=  '?selected_id='+selectedVal;
        $.ajax({
            url: listingUrl,
            type: 'get',
            cache: false,
            success: function (res) {
                $('#contactTermDiv').html(res);
            },
            error: function (xhr, textStatus, thrownError) {
            }
        });
    }else{
        $('#contactTermDiv').html('');
    }
}

$(document).ready(function(){
    var data = '';
    if($('#id').val() != ''){  
        var data= $("#construction_status_id").val();
        var dataarray=data.split(","); 
        $("#construction_status_id_multiselect").val(dataarray)
    }
    
    var data = '';
    if($('#id').val() != ''){  
        var data= $("#property_type_id").val();
        var dataarray=data.split(","); 
        $("#property_type_id_multiselect").val(dataarray)
    }
    
    $('#construction_status_id_multiselect').multiselect({
        nonSelectedText: 'Select Construction Status',
//        buttonWidth: 350,
//        enableFiltering: true,
        includeSelectAllOption: true,
        onChange: function(option, checked, select) { 
            $('#construction_status_id').val($('#construction_status_id_multiselect').val())
            //alert('Changed option ' + $(option).val() + '.');
        },
        
    });
    $('#property_type_id_multiselect').multiselect({
        nonSelectedText: 'Select Property Type',
//        buttonWidth: 350,
//        enableFiltering: true,
        includeSelectAllOption: true,
        onChange: function(option, checked, select) {
            $('#property_type_id').val($('#property_type_id_multiselect').val())
            //alert('Changed option ' + $(option).val() + '.');
        }
    });
    
});

$('.bnt_reorder_image').on('click', function(){  
    var photoObj            = {}, photoArr = [];
    var txtLength           =   $('.propertyImageCls').length; 
    for(var i= 0; i < txtLength;i++){
        var id              =  $("input[name='property_photo["+i+"][id]']").val();  
        var property_id     =   $("input[name='property_photo["+i+"][property_id]']").val();  //alert(id);
        var sort            =  $("input[name='property_photo["+i+"][sort_order]']").val();  //alert(sort);
        var title           =  $("input[name='property_photo["+i+"][description]']").val();  //alert(title);
        photoObj            = {id:id,property_id:property_id, title:title, sort:sort}; 
        photoArr.push(photoObj);
    }
    var params = {formData: photoArr}; 
    $.ajax({
        url: 'ordered-image-list',
        type: 'POST',
        data: JSON.stringify(params),
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (response, status, xhr){ 
            $('#orderedImageDiv').html(response);
        }
    });

    return false;

});
function goBack() {
    window.history.back();
}
function contactInfoDiv(selectedVal){
    listingUrl	=   'contact-info-div';
    listingUrl	+=  '?property_id='+selectedVal;
    $.ajax({
        url: listingUrl,
        type: 'get',
        cache: false,
        success: function (res) {
            $('#contactInfoDiv').html(res);
        },
        error: function (xhr, textStatus, thrownError) {
        }
    });
}
function deleteContactInfo(selectedVal,flag){ 
    if(confirm('Are you sure to delete ?')){
        listingUrl	=   'delete-contact-info';
        listingUrl	+=  '?property_id='+selectedVal+'&flag='+flag;
        $.ajax({
            url: listingUrl,
            type: 'get',
            cache: false,
            success: function (resp) {
                if (resp.success == true){
                    contactInfoDiv(resp.selectedVal);
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                }else{
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error: function (xhr, textStatus, thrownError) {
            }
        });
    }
    
}