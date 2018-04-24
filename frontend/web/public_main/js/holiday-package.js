$(document).ready(function() {
    $('.searchLink').click(function(){
            $('.adventure-search-box').slideDown();
    });
    $('.adventure-search-close').click(function(){
            $('.adventure-search-box').slideUp();
    });

    $('.btn_search_holiday-package').on('click', function(){
        var that            = $(this);
        var thisForm        = that.closest('form');
        var loc_from        = thisForm.find('.package_search_location_from').val();
        var loc_to          = thisForm.find('.package_search_location_to').val();
        var month_travel         = thisForm.find('.package_search_travel_month').val();
        if(loc_from == '' || loc_to == ''){
            return false;
        }
        var url = thisForm.attr('action');
        url = updateQueryStringParameter(url, 'source', loc_from);
        url = updateQueryStringParameter(url, 'destination', loc_to);
        if(month_travel){
            url = updateQueryStringParameter(url, 'month_travel', month_travel);
        }
        window.location = url;
    });
    
    
    
});