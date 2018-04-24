jQuery(document).on('click', '.mega-dropdown', function (e) {
    e.stopPropagation()
})
$(document).ready(function () {
    //Listing Slider
    $("#owl-demo").owlCarousel({
        items: 4,
        navigation: true,
        navigationText: ["<i class='fa fa-long-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>"],
    });

    //Counter
    $('.count').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
        });
    });

    //Footer Link Show/Hide
    $('.footer-more').click(function () {
        $(this).prev('.footer-extra-link').slideDown();
        $(this).hide();
        $(this).next('.footer-less').show();
    });

    $('.footer-less').click(function () {
        $(this).prev('.footer-more').prev('.footer-extra-link').slideUp();
        $(this).prev('.footer-more').show();
        $(this).hide();
    });

    //Go to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });

    //Click event to scroll to top
    $('.scrollToTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
    
    /**
     * Bootstrap modal handalling
    */
    
    $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
        $('#mls_bs_modal_one').off('hidden.bs.modal'); 
    });
    
    $(document).on('hidden.bs.modal', '#mls_bs_modal_one', function (e) { 
        if (typeof $(e.target).data('noremote') != 'undefined') {
            return true;
        }
        $(e.target).removeData('bs.modal');
        $(e.target).find('.modal-content').html(''); 
    });
    
    $(document).on('click', '.lnk_signup' ,function (e) {
        $('#mls_bs_modal_one').off('hidden.bs.modal'); 
        $('#mls_bs_modal_one').modal('hide');
         
        $('#mls_bs_modal_two').modal('show');
        $('body').addClass('modal-open'); 
        
    });
    
    $(document).on('click', '.lnk_login' ,function (e) {
        $('#mls_bs_modal_two').off('hidden.bs.modal'); 
        $('#mls_bs_modal_two').modal('hide');
         
        $('#mls_bs_modal_one').modal('show');
        $('body').addClass('modal-open'); 
        
    });
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



