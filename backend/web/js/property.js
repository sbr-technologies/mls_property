/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $( document ).ready(function() {
        $("#geocomplete_key1").geocomplete({
    //        map: ".map_canvas",
            //detailsAttribute: 'class^',
            //details: "form.frm_geocomplete",
            details: ".dest_details",
            detailsAttribute: "data-geo",
            types: ["geocode", "establishment"],
        });
        $("#geocomplete_key2").geocomplete({
    //        map: ".map_canvas",
            //detailsAttribute: 'class^',
            //details: "form.frm_geocomplete",
            details: ".dest_details",
            detailsAttribute: "data-geo",
            types: ["geocode", "establishment"],
        });
        $("#geocomplete_key3").geocomplete({
    //        map: ".map_canvas",
            //detailsAttribute: 'class^',
            //details: "form.frm_geocomplete",
            details: ".dest_details",
            detailsAttribute: "data-geo",
            types: ["geocode", "establishment"],
        });
       
        
        $(".datepkr").datepicker({
            language: 'pt-BR',
            format: 'dd/mm/yyyy',
            autoclose:true,
        });

        $(".timepicker").datetimepicker({
            format: 'LT'
        });
        var categoryId  =   $('#property_category_id').val(); 
        showHideDiv(categoryId);
        var propertyId  =   '';
        if($('#id').val() != ''){
            var propertyId  =   $('#id').val(); 
            var categoryId  =   $('#property_category_id').val();
            var marketStatus =  $('#market_status').val();
            showHideDiv(categoryId); 
            showHideSoldDiv(marketStatus);
        }
        
        var selectedVal = '';
        showhideContactDiv(selectedVal);
    });
    
    function showhideContactDiv(selectedVal){
        if(selectedVal == 'Buyer Agent'){
            $('.otherfieldCls').prop('disabled',true);
            $('.agentFieldCls').prop('disabled',false);
            $('.agentTypeCls').prop('disabled',false);
            $('.agentFieldCls').val('');
            $('.otherTypeCls').prop('disabled',true);
            $("#agentDetailsDiv").show();
            $("#otherDetailsDiv").hide();
        }else{
            $('.otherfieldCls').prop('disabled',false);
            $('.agentFieldCls').prop('disabled',true);
            $('.otherTypeCls').prop('disabled',false)
            $('.agentTypeCls').prop('disabled',true);
            $('.otherfieldCls').val('');
            $("#agentDetailsDiv").hide();
            $("#otherDetailsDiv").show();
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
    
    $(document).on('click', '.btn_add_property_feature_info', function () {
        var localInfoRowHtml = $('.dv_property_feature_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.dv_property_feature_info_container').append(localInfoRowHtml);
    });
    
    $(document).on('click', '.btn_add_hotel_booking_guest_info', function () {
        var factInfoRowHtml = $('.dv_hotel_booking_guest_info_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.dv_hotel_booking_guest_info_container').append(factInfoRowHtml);
    });
    
    $(document).on('click', '.btn_add_property_tax_history', function () {
        var localInfoRowHtml = $('.dv_property_tax_history_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.property_tax_history_container').append(localInfoRowHtml);
    });
    
   
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
            includeSelectAllOption: true,
            onChange: function(option, checked, select) { 
                $('#construction_status_id').val($('#construction_status_id_multiselect').val());
            },

        });
        $('#property_type_id_multiselect').multiselect({
            nonSelectedText: 'Select Property Type',
            includeSelectAllOption: true,
            onChange: function(option, checked, select) {
                $('#property_type_id').val($('#property_type_id_multiselect').val())
            }
        });

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
    function priceForList(selectedVal) {
        if(selectedVal != ''){
            listingUrl	=   'index.php?r=property/price-for-list';
            listingUrl	+=	'&selected_id='+selectedVal;
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
            listingUrl	=   'index.php?r=property/service-for-list';
            listingUrl	+=	'&selected_id='+selectedVal;
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
            listingUrl	=   'index.php?r=property/other-for-list';
            listingUrl	+=	'&selected_id='+selectedVal;
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
            listingUrl	=   'index.php?r=property/contact-term-list';
            listingUrl	+=	'&selected_id='+selectedVal;
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
            url: 'index.php?r=property/ordered-image-list',
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

    function deleteGalleryPhoto(selectedVal){ 
        if(confirm('Are you sure to delete ?')){
            listingUrl	=   'delete-photo';
            listingUrl	+=  '?photo_id='+selectedVal;
            $.ajax({
                url: listingUrl,
                type: 'get',
                cache: false,
                success: function (resp) {
                    if (resp.success == true){


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

    $(document).ready(function(){
        $(".add-required div.form-group").addClass("required");
    
    });