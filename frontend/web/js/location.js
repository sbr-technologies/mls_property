/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    $("#geocomplete").geocomplete({
//        map: "#dv_property_map_canvas",
        detailsAttribute: 'class^',
        details: "form.frm_geocomplete",
        types: ["geocode", "establishment"],
    });
    $("#geocomplete_agency").geocomplete({
//        map: ".map_canvas",
        //detailsAttribute: 'class^',
        //details: "form.frm_geocomplete",
        details: ".agency_addr_details",
        detailsAttribute: "data-geo",
        types: ["geocode", "establishment"],
    });
    $(".geocomplete_local_info").geocomplete({
//        map: ".map_canvas",
//        detailsAttribute: 'class^',
//        details: "form.frm_geocomplete",
        types: ["geocode", "establishment"],
    }).bind("geocode:result", function(event, result){
        console.log(result);
        var thisTarget = $(event.target);
        var lat = result.geometry.location.lat(), lng = result.geometry.location.lng();
        thisTarget.closest('.item').find('.lat').val(lat);
        thisTarget.closest('.item').find('.lng').val(lng);
    });
    $("#geocomplete_destination").geocomplete({
//        map: ".map_canvas",
        //detailsAttribute: 'class^',
        //details: "form.frm_geocomplete",
        details: ".dest_details",
        detailsAttribute: "data-geo",
        types: ["geocode", "establishment"],
    });
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
    $("#geocomplete_source").geocomplete({

        details: ".source_details",
        detailsAttribute: "data-geo",
        types: ["geocode", "establishment"],
    });
    $("#geocomplete_company").geocomplete({
        details: ".seller_addr_details",
        detailsAttribute: "data-geo",
        types: ["geocode", "establishment"],
    });
    $(document).on('click', '.btn_add_property_local_info', function () { 
        var curTime = Math.floor(Date.now() / 1000);
        var localInfoRowHtml = $('.dv_local_info_block_template').html().replace(/curTime/g, curTime);
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
    
    $(document).on('click', '.btn_add_property_tax_history', function () {
        var localInfoRowHtml = $('.dv_property_tax_history_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.property_tax_history_container').append(localInfoRowHtml);
    });
    $(document).on('click', '.btn_add_open_house_info', function () {
        var localInfoRowHtml = $('.dv_open_house_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.open_house_info_container').append(localInfoRowHtml);
        
        $(".datepkr").datepicker({
            language: 'pt-BR',
            format: 'dd/mm/yyyy',
            autoclose:true,
        });
        
        $(".timepicker").datetimepicker({
            format: 'LT'
        });
        
        
    });
    $(document).on('click', '.btn_add_property_feature_info', function () {
        var localInfoRowHtml = $('.dv_property_feature_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.dv_property_feature_info_container').append(localInfoRowHtml);
    });
//    $(document).on('click', '.btn_add_property_contact', function () {
//        var localInfoRowHtml = $('.dv_property_contact_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
//        $('.property_contact_container').append(localInfoRowHtml);
//    });
    
});
function resetFormVal(frmId,radVal,hidVal){		
    if(radVal == 1){
        $('#'+frmId).find('input:checkbox').removeAttr('checked').removeAttr('selected');
        $('.'+frmId).find('input:checkbox').removeAttr('checked').removeAttr('selected');
    }else{
        $('#'+frmId).find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
        $('.'+frmId).find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');			
    }
    if(hidVal == 1){
        $('#'+frmId).find('input:hidden').val('');
    }
    $('#'+frmId).find('input:password,input:text, input:file, select, textarea').val('');	
    $('.'+frmId).find('input:password,input:text, input:file, select, textarea').val('');
    $('.help-block help-block-error').remove();
}


                                    