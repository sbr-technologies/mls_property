
$(function(){
    $('form#frm_search_result_page_search').on('submit', function(){
        var thisForm            = $(this);
        var filters = {};
        thisForm.find($('.search_item')).each(function(){
            var thisItem = $(this);
            if(thisItem.val()){
                var name = thisItem.attr('name');
                filters[name] = thisItem.val();
            }
        });
        var params = {filters:filters, sortBy: $('.sort_teams_by').val()};
        
        $.ajax({
            url: thisForm.attr('action'),
            type: 'POST',
            data: JSON.stringify(params),
            contentType: 'application/json; charset=utf-8',
           // dataType: 'json',
            async: true,
            beforeSend: function(){
                $.loading();
            },
            success: function (response, status, xhr){
                $.loaded();
                $('#modal_agent_more_search').modal('hide');
                $('.team_search_result_container').html(response);
            }
        });
        return false;
    });
    
    $(document).on('click', '.team_member_header', function(){
        var thisLink = $(this);
        thisLink.next('.team_member_content').slideToggle().end().toggleClass('open');
        return false;
    });
    
        
    
    $(document).on('change', '.sort_teams_by', function(){
        $('.hid_search_page').val('0');
        $('#frm_search_result_page_search').submit();
    });
    
        
    $('.btn_filter_by_more').on('click', function (event) {
        toggleMoreFilter();
    });

    $('body').on('click', function (e) {
        if (!$('.btn_filter_by_more').is(e.target) 
            && $('.btn_filter_by_more').has(e.target).length === 0 
            && $('.open').has(e.target).length === 0 && !$('.select2-search__field').is(e.target)
        ) {
            closeMoreFilter();
        }
    });
    $('.btn_filter_by_more_options').on('click', function () {
        $('.hid_search_page').val('0');
        $('#frm_search_result_page_search').submit();
        closeMoreFilter();
    });

    $('.btn_filter_by_more_options_cancel').on('click', function () {
        closeMoreFilter();
    });
    
    $('.btn_filter_by_more_options_reset').on('click', function(){
       $('.property_more_filters').find('.search_item').each(function(){
           $(this).val('').trigger("change");
       }); 
    });
    
    $(document).on('click', '.find_agent_pagination a', function(e){
        var thisLink    =   $(this);
        $('.hid_search_page').val(thisLink.data('page'));
        $('#frm_search_result_page_search').submit();
        return false;
    });
});

function toggleMoreFilter() {
    $('.btn_filter_by_more').parent().toggleClass('open');
    $('body').toggleClass('overflow-hidden');
    $('.property-menu-bar').toggleClass('sticky');
}
function closeMoreFilter(){
    $('.btn_filter_by_more').parent().removeClass('open');
    $('body').removeClass('overflow-hidden');
    $('.property-menu-bar').removeClass('sticky');
}