/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $(document).on('click', '.property_pagination a', function(e){
        var thisLink    =   $(this);
        $('.hid_require_json').val('y');
        $('.hid_search_page').val(thisLink.data('page'));
        $('.frm_search_result_page_search').submit();
        return false;
    });
    $(document).on('click', '.lnk_add_to_compare', function(e){
        var thisBtn = $(this);
        var property_id     =   thisBtn.data('value');
        $.loading();
        $.ajax({
            url: $(this).data('url'),
            type: 'get',
            cache: false,
            success: function (res) { //alert($('#text_'+res.property_id).val());
                $.loaded();
                if(res.success ==true){
                    if(thisBtn.val() == 'Compare'){
                        if($('#compareCntId').val() < 3){
                            thisBtn.html('<i class="fa fa-minus" aria-hidden="true"></i>');
                            thisBtn.val('Added').attr('title', 'Added to compare');
                            $('#compareCntId').val(parseInt($('#compareCntId').val())+1);
                            $('#totalCntDiv').html($('#compareCntId').val());
                        }else{
                            alert("You can not added more than 3 property");
                        }
                    }else{
                        thisBtn.html('<i class="fa fa-plus" aria-hidden="true"></i>');
                        thisBtn.val('Compare').attr('title', 'Add to compare');;
                        $('#compareCntId').val(parseInt($('#compareCntId').val())-1);
                        $('#totalCntDiv').html($('#compareCntId').val());
                    }
                    if ($('#compareCntId').val() > 0) {
                        $('.lnk_compare_property').show();
                    } else {
                        $('.lnk_compare_property').hide();
                    }
                }else if(res.success == false){
                    alert(res.message);
                }
            },
            error: function (xhr, textStatus, thrownError) {
                alert('error')
            }
        });
        return false;
    });
    $(document).on('click','.lnk_compare_property', function(){
        if($('#compareCntId').val() <= 1){
            alert("Please add at least 2 property to compare");
            return false;
        }
    });
    
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 165){  
         //$('.scroll-top-sec').show();
         $('.property-menu-bar').addClass("headerstuck");
          }
          else{
            $('.property-menu-bar').removeClass("headerstuck");
          }
     });
     
//    $('form.frm_search_result_page_search').on('change', '.txt_location_suggestion', function(){
//        if($(this).val() == ''){
//            $('.hid_realestate_search_location').val('');
//        }
//    });
    
    
    $('form.frm_search_result_page_search').on('submit', function(){
        var thisForm = $('form.frm_search_result_page_search');
//        if(thisForm.find('.hid_realestate_search_location').val() == ''){
//            return false;
//        }

        var typeItems = [], constStatuses = [], marketStatuses = [], categories = [], locationArr, city = null, state = null, zipCode = null, viewType = $('.hid_view_type').val();
        
        var requireJson = $('.hid_require_json').val();
        $.each($("input[name='chk_filter_property_type[]']:checked"), function() {
            typeItems.push($(this).val());
        });
        
        $.each($("input[name='chk_filter_property_const_status[]']:checked"), function() {
            constStatuses.push($(this).val());
        });
        $.each($("input[name='chk_filter_property_market_status[]']:checked"), function() {
            marketStatuses.push($(this).val());
        });
        $.each($("input[name='chk_filter_property_category[]']:checked"), function() {
            categories.push($(this).val());
        });
        var generalItems    = $(".txt_filter_general_feature").val();
        var exteriorItems   = $(".txt_filter_exterior_feature").val();
        var interiorItems   = $(".txt_filter_interior_feature").val();
        var pageNumber            = $(".hid_search_page").val();

        var params = {
            filters:{min_price: $('.txt_filter_min_price').val(), max_price: $('.txt_filter_max_price').val(), bedroom: $('.txt_filter_bedroom').val(), bathroom: $('.txt_filter_bathroom').val(), garage: $('.txt_filter_garage').val(),
            categories: categories, prop_types: typeItems, general_features: generalItems,exterior_features: exteriorItems,interior_features: interiorItems,
            const_status:constStatuses, market_statuses:marketStatuses,
            sole_mandate: $('.chk_filter_sole_mandate:checked').val(), featured_listing: $('.chk_filter_featured_listing:checked').val(),
            lot_size: $('.txt_filter_lot_size').val(), building_size: $('.txt_filter_building_size').val(), house_size: $('.txt_filter_house_size').val(),
            no_of_toilet: $('.txt_filter_no_of_toilet').val(), no_of_boys_quater: $('.txt_filter_no_of_boys_quater').val(), year_built: $('.txt_filter_year_built').val(),
            agency_id: $('.txt_filter_agency_id').val(), agency_name: $('.txt_filter_agency_name').val(), team_id: $('.txt_filter_team_id').val(), team_name: $('.txt_filter_team_name').val(), agent_id: $('.txt_filter_agent_id').val(), agent_name: $('.txt_filter_agent_name').val(),
            listing_from_date: $('.txt_filter_listing_from_date').val(), listing_to_date: $('.txt_filter_listing_to_date').val(),
            closing_from_date: $('.txt_filter_closing_from_date').val(), closing_to_date: $('.txt_filter_closing_to_date').val(),
            property_id:$('.txt_filter_property_id').val(),
            state: $('.txt_filter_state').val(), town: $('.txt_filter_town').val(), area: $('.txt_filter_area').val(), zip_code:$('.txt_filter_zip_code').val(), local_govt_area:$('.txt_filter_local_govt_area').val(), district:$('.txt_filter_district').val(),
            street_address:$('.txt_filter_street_address').val(),street_number:$('.txt_filter_street_number').val(), appartment_unit:$('.txt_filter_appartment_unit').val(), urban_town_area:$('.txt_filter_urban_town_area').val(),
            condominium: $('.txt_filter_condominium').val()
            },
            sort: $('.sort_property_by').val(),
            type: $('.hid_search_category').val(),
            require_json: requireJson,
            view_type: viewType,
            page:pageNumber
        };
//        $.post(thisForm.attr('action'), params, function(response){
//            $('.property_search_result_container').html(response);
//        });
        var url = thisForm.find('.hid_property_listing_base').val();
        var urlPath = url + '?'+ $.param(params.filters);
        
        params.list_url = urlPath;

        $.ajax({
            url: thisForm.attr('action'),
            type: 'POST',
            data: JSON.stringify(params),
            contentType: 'application/json; charset=utf-8',
            dataType: (viewType === 'list' || requireJson === 'y'? 'html':'json'),
            async: true,
            beforeSend: function(){
                $.loading();
            },
            success: function (response, status, xhr){
                window.history.pushState("","", urlPath);
                $.loaded();
                console.log(tempState+"--"+tempTown+"--"+tempArea);
                var ct = xhr.getResponseHeader("content-type") || "";
                if (ct.indexOf('html') > -1) {
                    $('.property_search_result_container').html(response);
                    if(viewType === 'list'){
                        $('footer').show();
                        $('.search_result_left').removeClass('col-sm-4 col-sm-push-8 clearfix').addClass('col-sm-9');
                        $('.property-listing-top-title').removeClass('col-sm-4 col-sm-push-8 clearfix');
                        $('.search_result_right_sidebar').show();
                        $('.realestate_map_view_container').hide();
                    }
                    if(viewType === 'map' && requireJson === 'y'){
                        $('.frm_search_result_page_search').find('.hid_require_json').val('n');
                        $('.frm_search_result_page_search').submit();
                    }
                }else if (ct.indexOf('json') > -1) {
                    $('footer').hide();
                    $('.search_result_right_sidebar').hide();
                    $('.search_result_left').removeClass('col-sm-9').addClass('col-sm-4 col-sm-push-8 clearfix');
                    $('.property-listing-top-title').addClass('col-sm-4 col-sm-push-8 clearfix');
                    $('.realestate_map_view_container').show();
                    $('.frm_search_result_page_search').find('.hid_require_json').val('n');
                    initialize(response.results.items);
                } 
                if(tempState!=""){
                 $('#multiXX1').multiselect('select',tempState,true);
                }
                tempState='';
            },
            error: function(){
                $.loaded();
            }
        });
        
        return false;
    });
    
    $(document).on('click', '.min_price_option_group a', function (e) {
        e.stopPropagation();
        $('.txt_filter_min_price').val($(this).data('val'));
        $('.min_price_option_group').css('visibility', 'hidden');
        $('.max_price_option_group').css('visibility', 'visible');
        var min = $('.txt_filter_min_price').val();
        var max = $('.txt_filter_max_price').val();
        $('.btn_filter_by_price .btntext').text(getPriceButtonText(min, max));
        $('.txt_filter_max_price').focus();
    });
    
    $(document).on('click', '.max_price_option_group a', function (e) {
        $('.txt_filter_max_price').val($(this).data('val'));
        var min = $('.txt_filter_min_price').val();
        var max = $('.txt_filter_max_price').val();
        $('.btn_filter_by_price .btntext').text(getPriceButtonText(min, max));
    });
    
    $('.txt_filter_min_price').on('focus', function(){
        $('.min_price_option_group').css('visibility', 'visible');
        $('.max_price_option_group').css('visibility', 'hidden');
    });
    
    $('.txt_filter_max_price').on('focus', function(){
        $('.min_price_option_group').css('visibility', 'hidden');
        $('.max_price_option_group').css('visibility', 'visible');
    });
    
    $('.any-price-menu').on('hide.bs.dropdown', function () {
        var min = $('.txt_filter_min_price').val();
        var max = $('.txt_filter_max_price').val();
        $('.min_price_option_group').css('visibility', 'hidden');
        $('.max_price_option_group').css('visibility', 'hidden');
        $('.btn_filter_by_price .btntext').text(getPriceButtonText(min, max));
        if($('.hid_view_type').val() === 'map' && $('.hid_require_json').val()==='n'){
            $('.hid_require_json').val('y');
        }
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
    });
    
    $('.any-price-menu').on('show.bs.dropdown', function () {
        $('.min_price_option_group').css('visibility', 'visible');
        $('.txt_filter_min_price').focus();
    });
    
    
    
    
    /*************************************************************/
    $(document).on('click', '.bedroom_option_group a', function (e) {
        $('.txt_filter_bedroom').val($(this).data('val'));
        $('.btn_filter_by_bedroom .btntext').text($(this).text()+ ' Beds');
    });
    
    $('.bedroom_dropdown').on('hide.bs.dropdown', function () {
        if($('.hid_view_type').val() === 'map' && $('.hid_require_json').val()==='n'){
            $('.hid_require_json').val('y');
        }
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
    });
    
    
    /*************************************************************/
    $(document).on('click', '.bathroom_option_group a', function (e) {
        $('.txt_filter_bathroom').val($(this).data('val'));
        $('.btn_filter_by_bathroom .btntext').text($(this).text()+ ' Baths');
    });
    
    $('.bathroom_dropdown').on('hide.bs.dropdown', function () {
        if($('.hid_view_type').val() === 'map' && $('.hid_require_json').val()==='n'){
            $('.hid_require_json').val('y');
        }
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
    });
    
    
    
    /***************************Filter by property category**********************************/

    $(document).on('change', '.chk_filter_prop_category', function (e) {
        var btnText;
        if($("input[name='chk_filter_property_category[]']:checked").length == 1){
            btnText = $("input[name='chk_filter_property_category[]']:checked").data('text_val');
        }else if($("input[name='chk_filter_property_category[]']:checked").length == 0){
            btnText = 'Category';
        }else{
            btnText = 'Category ('+ $("input[name='chk_filter_property_category[]']:checked").length+')';
        }
        $('.btn_filter_by_prop_category .btntext').text(btnText);
    });
    
    $('.prop_category_dropdown').on('hide.bs.dropdown', function () {
        if($('.hid_view_type').val() === 'map' && $('.hid_require_json').val()==='n'){
            $('.hid_require_json').val('y');
        }
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
    });
    
    /**************************************************************************/
    
    
    /*************************Filter by property type************************************/
    $(document).on('change', '.chk_filter_property_type', function (e) {
        var btnText;
        if($("input[name='chk_filter_property_type[]']:checked").length == 1){
            btnText = $("input[name='chk_filter_property_type[]']:checked").data('text_val');
        }else if($("input[name='chk_filter_property_type[]']:checked").length == 0){
            btnText = 'Property type';
        }else{
            btnText = 'Property type ('+ $("input[name='chk_filter_property_type[]']:checked").length+')';
        }
        $('.btn_filter_by_prop_type .btntext').text(btnText);
    });
    
    $('.property_type_dropdown').on('hide.bs.dropdown', function () {
        if($('.hid_view_type').val() === 'map' && $('.hid_require_json').val()==='n'){
            $('.hid_require_json').val('y');
        }
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
    });
    
    /*************************Filter by property Construction Status************************************/
    $(document).on('change', '.chk_filter_property_const_status', function (e) {
        var btnText;
        if($("input[name='chk_filter_property_const_status[]']:checked").length == 1){
            btnText = $("input[name='chk_filter_property_const_status[]']:checked").data('text_val');
        }else if($("input[name='chk_filter_property_const_status[]']:checked").length == 0){
            btnText = 'Construction Status';
        }else{
            btnText = 'Construction Status ('+ $("input[name='chk_filter_property_const_status[]']:checked").length+')';
        }
        $('.btn_filter_by_const_status .btntext').text(btnText);
    });
    
    $('.property_const_status_dropdown').on('hide.bs.dropdown', function () {
        if($('.hid_view_type').val() === 'map' && $('.hid_require_json').val()==='n'){
            $('.hid_require_json').val('y');
        }
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
    });
    
    /**************************************************************************/
    
    /*************************Filter by property Market Status************************************/
    $(document).on('change', '.chk_filter_property_market_status', function (e) {
        var btnText;
        if($("input[name='chk_filter_property_market_status[]']:checked").length == 1){
            btnText = $("input[name='chk_filter_property_market_status[]']:checked").data('text_val');
        }else if($("input[name='chk_filter_property_market_status[]']:checked").length == 0){
            btnText = 'Market Status';
        }else{
            btnText = 'Market Status ('+ $("input[name='chk_filter_property_market_status[]']:checked").length+')';
        }
        $('.btn_filter_by_market_status .btntext').text(btnText);
    });
    
    $('.property_market_status_dropdown').on('hide.bs.dropdown', function () {
        if($('.hid_view_type').val() === 'map' && $('.hid_require_json').val()==='n'){
            $('.hid_require_json').val('y');
        }
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
    });
    
    /**************************************************************************/
    
    $(document).on('change', '.sort_property_by', function(){
        if($('.hid_view_type').val() === 'map' && $('.hid_require_json').val()==='n'){
            $('.hid_require_json').val('y');
        }
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
    });

    $(document).on('click', '.realestate_search_list_view', function(){
        $(this).siblings().removeClass('active').end().addClass('active');
        $('.frm_search_result_page_search').find('.hid_view_type').val('list');
        $('.property-menu-bar-inner').show();
        $('.map-view .property_search_result_container').removeAttr('style');
        $('body').removeClass('map-view');
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
        return false;
    });
    
    /**************************Garage***********************************/
    $(document).on('click', '.garage_option_group a', function (e) {
        $('.txt_filter_garage').val($(this).data('val'));
        $('.btn_filter_by_garage .btntext').text($(this).text()+ ' Garages');
    });
    
    $('.garage_dropdown').on('hide.bs.dropdown', function () {
        if($('.hid_view_type').val() === 'map' && $('.hid_require_json').val()==='n'){
            $('.hid_require_json').val('y');
        }
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
    });
    
/**
 * More filters
 */

$('.btn_filter_by_more').on('click', function (event) {
    $('.hid_realestate_search_location').val('');
    toggleMoreFilter();
});
$('body').on('click', function (e) {
    if (!$('.btn_filter_by_more').is(e.target) 
        && $('.btn_filter_by_more').has(e.target).length === 0 
        && $('.open').has(e.target).length === 0
    ) {
        closeMoreFilter();
    }
});    

$('.btn_filter_by_more_options').on('click', function(){
    $('.hid_search_page').val('0');
    $('.frm_search_result_page_search').submit();
    closeMoreFilter();
});

$('.btn_filter_by_more_options_cancel').on('click', function(){
    closeMoreFilter();
});

$('.btn_filter_by_more_options_reset').on('click', function(){
   $('.property_more_filters').find('.search_item').each(function(){
       $(this).val('').trigger("change");
   });
   
   $('#multiXX1').multiselect('rebuild');
   $('#multiXX2').empty();
   $('#multiXX2').multiselect('rebuild');
   $('#multiXX3').empty();
   $('#multiXX3').multiselect('rebuild');
   $('#multiXX4').empty();
   $('#multiXX4').multiselect('rebuild');
   $('#multiXX5').empty();
   $('#multiXX5').multiselect('rebuild');
   $('#multiXX6').empty();
   $('#multiXX6').multiselect('rebuild');
   $('.multiselect_dropdown').multiselect('rebuild');
});
    
$('.sel_property_category').on('change', function(){
   var type;
    if($(this).val() == 1){
       type = 'Rental';
    }else if($(this).val() == 2){
       type = 'Property';
    }else if($(this).val() == 3){
       type = 'ShortLet';
    }
    $('.hid_search_category').val(type);
    propertyTypeList($(this));
});

/********************
 * 
 * Map view Search section starts
 * 
 ********************/


    $(document).on('click', '.realestate_search_map_view', function(){
        $(this).siblings().removeClass('active').end().addClass('active');
        $('.frm_search_result_page_search').find('.hid_view_type').val('map');
        $('body').addClass('map-view');
		$('.property-menu-bar-inner').hide();
		var windowHeaight = $(window).height();
		var headertopHeight = $('.mainheader').height();
		//alert(windowHeaight);
		var headerbottomHeight = $('.property-menu-bar').height();
		var totaHeader = headertopHeight + headerbottomHeight;
		//alert(totaHeader);
		$('.map-view .property_search_result_container').css({'height': windowHeaight - totaHeader + 'px', 'margin-top' : totaHeader + 'px'});
                $('.realestate_map_view_container').css({'height': windowHeaight - totaHeader + 'px', 'margin-top' : totaHeader + 'px'});
	$('.hid_require_json').val('y');
        $('.hid_search_page').val('0');
        $('.frm_search_result_page_search').submit();
        return false;
    });


    $('body').click(function(e) {
        if (!$('.html_marker').is(e.target) && !$('.map-upon-pop').children().is(e.target)){
           $("#xPopup").hide();
        }


        /**
         * Events on listing page
         */
        $(document).on('click', '.save_prop_as_favorite', function(){

        });
    });

    $('body').on('mouseover', '.listing_item', function(){
        var thisItem = $(this);
        var markers = $('.realestate_map_view_container').find('.html_marker');
        markers.each(function(){
            if($(this).data('id') == thisItem.data('id')){
                $(this).addClass('selected');
            }
        });
    });

    $('body').on('mouseout', '.listing_item', function(){
        var markers = $('.realestate_map_view_container').find('.html_marker');
        markers.removeClass('selected');
    });
    
    $(document).on('click', '.btn_save_property_search', function(){
        var thisBtn = $(this);
        var typeItems = [], constStatuses = [], marketStatuses = [], categories = [], recipients = [];
        var nameField = $('.txt_save_search_name');
        if(!nameField.val()){
            nameField.parent('.form-group').addClass('has-error');
            nameField.next('.error').html('This field is required');
            return false;
        }else{
            nameField.parent('.form-group').removeClass('has-error');
            nameField.next('.error').empty();
        }
        $.loading;
        $.each($("input[name='chk_filter_property_type[]']:checked"), function() {
            typeItems.push($(this).val());
        });
        $.each($("input[name='chk_filter_property_const_status[]']:checked"), function() {
            constStatuses.push($(this).val());
        });
        $.each($("input[name='chk_filter_property_market_status[]']:checked"), function() {
            marketStatuses.push($(this).val());
        });
        $.each($("input[name='chk_filter_property_category[]']:checked"), function() {
            categories.push($(this).val());
        });
        var locationId = $('.hid_realestate_search_location').val();
        var locationArr = locationId.split('_');
        if(locationArr.length == 1){
            var zipCode = locationArr[0];
        }else{
            var city = locationArr[0], state = locationArr[1];
        }
        var generalItems    = $(".txt_filter_general_feature").val();
        var exteriorItems   = $(".txt_filter_exterior_feature").val();
        var interiorItems   = $(".txt_filter_interior_feature").val(); 
        
//        $.each($("input[name='construction_status[]']:selected"), function() {
//            constStatusItems.push($(this).val());
//        });
        
        $.each($(".txt_save_search_recipient"), function() {
            if($(this).val()){
                recipients.push($(this).val());
            }
        });

            var params = {name: $('.txt_save_search_name').val(), 
            cc_self: $('.chk_save_search_cc_self:checked').val(),
            recipients: recipients, schedule: $('.sel_save_search_schedule_alert').val(), message: $('.txt_save_search_message').val(),
            search_string: {location: $('.hid_realestate_search_location').val(),
            filters:{min_price: $('.txt_filter_min_price').val(), max_price: $('.txt_filter_max_price').val(), bedroom: $('.txt_filter_bedroom').val(), bathroom: $('.txt_filter_bathroom').val(), garage: $('.txt_filter_garage').val(),
            categories: categories, prop_types: typeItems,general_features: generalItems,exterior_features: exteriorItems,interior_features: interiorItems,
            const_statuses:constStatuses, market_statuses:marketStatuses,
            sole_mandate: $('.chk_filter_sole_mandate:checked').val(), featured_listing: $('.chk_filter_featured_listing:checked').val(),
            lot_size: $('.txt_filter_lot_size').val(), building_size: $('.txt_filter_building_size').val(), house_size: $('.txt_filter_house_size').val(),
            no_of_toilet: $('.txt_filter_no_of_toilet').val(), no_of_boys_quater: $('.txt_filter_no_of_boys_quater').val(), year_built: $('.txt_filter_year_built').val(),
            agency_id: $('.txt_filter_agency_id').val(), agency_name: $('.txt_filter_agency_name').val(),
            agent_id: $('.txt_filter_agent_id').val(), agent_name: $('.txt_filter_agent_name').val(),
            listing_from_date: $('.txt_filter_listing_from_date').val(), listing_to_date: $('.txt_filter_listing_to_date').val(),
            closing_from_date: $('.txt_filter_closing_from_date').val(), closing_to_date: $('.txt_filter_closing_to_date').val(),
            property_id:$('.txt_filter_property_id').val(),street_address:$('.txt_filter_street_address').val(),street_number:$('.txt_filter_street_number').val(),
            appartment_unit:$('.txt_filter_appartment_unit').val(),
            urban_town_area:$('.txt_filter_urban_town_area').val(),
            state: $('.txt_filter_state').val(), town: $('.txt_filter_town').val(), area: $('.txt_filter_area').val(), zip_code:$('.txt_filter_zip_code').val(), local_govt_area:$('.txt_filter_local_govt_area').val(), district:$('.txt_filter_district').val(),
            },
            sort: $('.sort_property_by').val(),
            type: $('.hid_search_category').val()}};
            $.ajax({
                url: thisBtn.data('url'),
                type: 'POST',
                data: JSON.stringify(params),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                async: true,
                beforeSend: function(){
                    $.loading();
                },
                success: function (response, status, xhr){
                    $.loaded(response.message);
                    $('#mdl_save_property_search').modal('hide');
                }
            });
    });
});
var overlay;


function initialize(items) {
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
    
    var gmap = new google.maps.Map(document.getElementById('realestate_map_view_container'), mapOptions);
    var htmlMarker = [], i, infoWindowContent = [];
    var bounds = new google.maps.LatLngBounds();
    var infoWindow = new google.maps.InfoWindow();
    function HTMLMarker(id){
        this.id = id;
//        this.lat = lat;
//        this.lng = lng;
//        this.price = price;
//        this.price_as = price_as;
//        this.feature_image = feature_image;
//        this.detail_url = detail_url;
//        this.address = address;
        this.pos = new google.maps.LatLng(items[id].lat,items[id].lng);
    }
    
    HTMLMarker.prototype = new google.maps.OverlayView();
    HTMLMarker.prototype.onRemove= function(){}
    
    //init your html element here
    HTMLMarker.prototype.onAdd= function(){
        this.div = document.createElement('DIV');
        this.div.className = "html_marker";
        this.div.style.position='absolute';
        this.div.style.cursor = 'pointer';
        this.div.innerHTML = '<span class="map-upon-pop"><strong>'+ kFormatter(items[this.id].price)+ '</strong></span>';
        this.div.setAttribute('data-id', this.id);
        if(items[this.id].is_fav){
            this.div.className = "html_marker favorite";
        }
//        this.div.setAttribute('data-price', this.price);
//        this.div.setAttribute('data-price_as', this.price_as);
//        this.div.setAttribute('data-feature_image', this.feature_image);
//        this.div.setAttribute('data-detail_url', this.detail_url);
//        this.div.setAttribute('data-address', this.address);
        var panes = this.getPanes();
        panes.overlayImage.appendChild(this.div);
    }
    
    HTMLMarker.prototype.draw = function(){
        var overlayProjection = this.getProjection();
        var position = overlayProjection.fromLatLngToDivPixel(this.pos);
        var panes = this.getPanes();
        this.div.style.left = position.x + 'px';
        this.div.style.top = position.y + 'px';
        this.div.onclick = function(){
            var tpl = _.template($('#usageList').html());
            var id = this.getAttribute('data-id');
            var price = items[id].price_as;
            var featureImage = items[id].feature_image;
            var detailUrl = items[id].detail_url;
            var address = items[id].address;
            var bedroom = items[id].bedroom;
            var bathroom = items[id].bathroom;
            var area = items[id].size;
            var popup = document.getElementById('xPopup');
            popup.innerHTML = tpl({price: price, feature_image: featureImage, detail_url: detailUrl, address: address, bedroom: bedroom, bathroom: bathroom, area: area});
            popup.style.display = 'block';
            popup.style.left = position.x + 100 + 'px';
            popup.style.top = position.y + 250 + 'px';
        };
    }
    var item;
    for (var key in items) {
        item = items[key];
        var position = new google.maps.LatLng(item.lat, item.lng);
        bounds.extend(position);
        htmlMarker[key] = new HTMLMarker(item.id);
        htmlMarker[key].setMap(gmap);
        gmap.fitBounds(bounds);
        console.log(item);      
    }
    
//    for (i = 0; i < items.length; i++) {
//        
//    }
    gmap.addListener('dragend',function(event) {
        $('.frm_search_result_page_search').submit();
    });
}

$(function(){
    $(document).on('click', '.save_as_favorite', function(){
        var thisBtn = $(this);
        $.get(thisBtn.data('href'), function(response){
            if(response.status === true){
                var markers = $('.realestate_map_view_container').find('.html_marker');
                if(response.insert === true){
                    thisBtn.find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                    markers.each(function(){
                        if($(this).data('id') == response.id){
                            $(this).addClass('favorite');
                        }
                    });
                }else{
                    thisBtn.find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
                    markers.each(function(){
                        if($(this).data('id') == response.id){
                            $(this).removeClass('favorite');
                        }
                    });
                }
            }else{
                $('#mls_bs_modal_one').modal({remote: loginPopupurl});
                $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                    $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                });
            }
        });
    });
});

function toggleMoreFilter(){
    $('.btn_filter_by_more').parent().toggleClass('open');
    $('body').toggleClass('overflow-hidden');
    $('.property-menu-bar').toggleClass('sticky');
}

function closeMoreFilter(){
    $('.btn_filter_by_more').parent().removeClass('open');
    $('body').removeClass('overflow-hidden');
    $('.property-menu-bar').removeClass('sticky');
}

function openMoreFilter(){
    $('.btn_filter_by_more').parent().toggleClass('open');
    $('body').addClass('overflow-hidden');
    $('.property-menu-bar').addClass('sticky');
}

function propertyTypeList(selectedCat) { 
    if(selectedCat.val() != ''){
        listingUrl	=   selectedCat.data('type_list_link');
        listingUrl	+=  '?selected_id='+selectedCat.val();
        $.ajax({
            url: listingUrl,
            type: 'get',
            cache: false,
            success: function (res) {
                $('.div_property_type').html(res);
                $('.multiselect_dropdown').multiselect('refresh');
            },
            error: function (xhr, textStatus, thrownError) {
            }
            
        });
    }else{
        $('#propertyTypeDiv').html('');
    }
}