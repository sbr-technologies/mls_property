$(function(){
    $(window).scroll(function() {
        if ($(this).scrollTop() > 165){  
         //$('.scroll-top-sec').show();
         $('.property-menu-bar').addClass("headerstuck");
          }
          else{
            $('.property-menu-bar').removeClass("headerstuck");
          }
     });
     
    $('form.frm_search_result_page_search').on('change', '.txt_location_suggestion', function(){
        if($(this).val() == ''){
            $('.hid_agent_search_location').val('');
        }
    });
    $('form.frm_search_result_page_search').on('change', '.txt_agent_suggestion', function(){
        if($(this).val() == ''){
            $('.hid_agent_search').val('');
        }
    });
    $('form.frm_search_result_page_search').on('submit', function(){
        var thisForm = $('form.frm_search_result_page_search');
//        if(thisForm.find('.hid_agent_search_location').val() == ''){
//            return false;
//        }
        
        var facilities = [], locationArr, city = null, state = null, zipCode = null, viewType = $('.hid_view_type').val();
        $.each($("input[name='chk_filter_hotel_facilities[]']:checked"), function() {
            facilities.push($(this).val());
        });
        var locationId = $('.hid_hotel_search_location_id').val();
            locationArr = locationId.split('_');
            if(locationArr.length == 1){
                zipCode = locationArr[0];
            }else{
                city = locationArr[0], state = locationArr[1];
            }
        var params = {location: $('.hid_hotel_search_location_id').val(), city:city, state:state, zip_code:zipCode,
            filters:{name: $('.txt_filter_hotel_name').val(), facilities: facilities, recommendation: $('.txt_filter_agent_recommendation').val(),
            rating: $('.hid_filter_hotel_rating').val()},
            sort: $('.sort_hotel_by').val()
        };

        $.ajax({
            url: thisForm.attr('action'),
            type: 'POST',
            data: JSON.stringify(params),
            contentType: 'application/json; charset=utf-8',
            async: true,
            success: function (response, status, xhr){
                $('.hotel_search_result_container').html(response);
            }
        });
        
        return false;
    });
    
    $('.filter_hotel_by_rating').on('click', 'a', function(){
        $('.hid_filter_hotel_rating').val($(this).data('value'));
        $('.btn_filter_by_rating .btntext').text($(this).data('value')+ ($(this).data('value')?' Star':'Rating'));
        $('.frm_search_result_page_search').submit();
    });
    
    $('.filter_agent_by_recommendation').on('click', 'a', function(){
        $('.txt_filter_agent_recommendation').val($(this).data('value'));
        $('.btn_filter_by_recommendation .btntext').text($(this).data('value')+ ($(this).data('value')?'+ Recomm':'Recommendation'));
        $('.frm_search_result_page_search').submit();
    });
    
    $('.filter_agent_by_worked_with').on('click', 'a', function(){
        $('.txt_filter_agent_worked_with').val($(this).data('value'));
        $('.btn_filter_by_worked_with .btntext').text(($(this).data('value')?$(this).text():'Worked With'));
        $('.frm_search_result_page_search').submit();
    });
    
    
    /****************************Property type*********************************/
    $(document).on('change', '.chk_filter_hotel_facilities', function (e) {
        var btnText;
        if($("input[name='chk_filter_hotel_facilities[]']:checked").length == 1){
            btnText = $("input[name='chk_filter_hotel_facilities[]']:checked").data('text_val');
        }else if($("input[name='chk_filter_hotel_facilities[]']:checked").length == 0){
            btnText = 'Facilities';
        }else{
            btnText = 'Facilities ('+ $("input[name='chk_filter_hotel_facilities[]']:checked").length+')';
        }
        $('.btn_filter_by_hotel_facilities .btntext').text(btnText);
    });
    
    $('.hotel_facilities_dropdown').on('hide.bs.dropdown', function () {
        $('.frm_search_result_page_search').submit();
    });
    
    /**************************************************************************/
    
    
    $(document).on('change', '.sort_hotel_by', function(){
        $('.frm_search_result_page_search').submit();
    });
});
    