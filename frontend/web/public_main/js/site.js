String.prototype.trimToLength = function(m) {
  return (this.length > m) 
    ? jQuery.trim(this).substring(0, m).split(" ").slice(0, -1).join(" ") + "..."
    : this;
};

jQuery(document).on('click', '.mega-dropdown', function(e) {
  e.stopPropagation()
})

$('.trigger').click(function() {
    $('.package-content').hide();
    $('.' + $(this).data('rel')).show();
});
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
       return false;
    }
    return true;
}
$(document).ready(function () {
    
    $('.btn_search_realestate').on('click', function(){
        var that = $(this);
        var thisForm = that.closest('form');
        var rentType = thisForm.find('.realestate_search_rent_type').val();
        var loc = thisForm.find('.realestate_search_location').val();
        var minPrice = thisForm.find('.adv_min_price').val();
        var maxPrice = thisForm.find('.adv_max_price').val();
        var bedroom = thisForm.find('.adv_bedroom').val();
        var bathroom = thisForm.find('.adv_bathroom').val();
        var propType = thisForm.find('.adv_property_type').val();
        var constStatus = thisForm.find('.adv_construction_status').val();
        var marktStatus = thisForm.find('.adv_market_status').val();
        var propertyID = thisForm.find('.adv_propertyid').val();
        
        if(!loc){
            alert('Please select a location');
            thisForm.find('.adventure-search-box').slideUp();
            return false;
        }
        var url = thisForm.attr('action');
        var loca = loc.split(', '), state, town, area;
        if(loca.length === 1){
            state = loca[0];
            url = updateQueryStringParameter(url, 'state', state);
        }else if(loca.length === 2){
            town = loca[0];
            state = loca[1];
            url = updateQueryStringParameter(url, 'town', town);
            url = updateQueryStringParameter(url, 'state', state);
        }else if(loca.length === 3) {
            area = loca[0];
            town = loca[1];
            state = loca[2];
            url = updateQueryStringParameter(url, 'area', area);
            url = updateQueryStringParameter(url, 'town', town);
            url = updateQueryStringParameter(url, 'state', state);
        }
        
        if(rentType){
            url = updateQueryStringParameter(url, 'rent_type', rentType);
        }if(minPrice){
            url = updateQueryStringParameter(url, 'min_price', minPrice);
        }if(maxPrice){
            url = updateQueryStringParameter(url, 'max_price', maxPrice);
        }if(bedroom){
            url = updateQueryStringParameter(url, 'bedroom', bedroom);
        }if(bathroom){
            url = updateQueryStringParameter(url, 'bathroom', bathroom);
        }if(propType){
            url = updateQueryStringParameter(url, 'prop_types', propType);
        }if(constStatus){
            url = updateQueryStringParameter(url, 'const_status', constStatus);
        }if(marktStatus){
            url = updateQueryStringParameter(url, 'market_statuses', marktStatus);
        }if(propertyID){
            url = updateQueryStringParameter(url, 'property_id', propertyID);
        }
 
        window.location.href = url;
    });
    
    
    $(document).on('click', '.btn_search_hotel', function(){
        var that = $(this);
        var thisForm = that.closest('form');
        var loc = thisForm.find('.realestate_search_location').val();
        var rating = thisForm.find('.adv_user_rating').val();
        var facilities = [];
        $.each($("input[name='chk_filter_hotel_facilities[]']:checked"), function() {
            facilities.push($(this).val());
        });
        if(!loc){
            alert('Please select a location');
            thisForm.find('.adventure-search-box').slideUp();
            return false;
        }
        var url = thisForm.attr('action');
        url = updateQueryStringParameter(url, 'location', loc);
        if(rating){
            url = updateQueryStringParameter(url, 'rating', rating);
        }if(facilities){
            url = updateQueryStringParameter(url, 'facilities', facilities.join('-'));
        }
        
        window.location.href = url;
    });
    
    
    $('.btn_search_agent').on('click', function(){ 
        var that = $(this), url;
        var thisForm = that.closest('form');
        var loc = thisForm.find('.realestate_search_location').val();
        var agent = thisForm.find('.realestate_search_agent').val();
        url = updateQueryStringParameter(thisForm.attr('action'), 'locations', loc);
        url = updateQueryStringParameter(url, 'agent', agent);
        window.location.href = url;
    });
    
    $('.btn_get_property_estimate').on('click', function(){ 
        var that = $(this), url;
        var thisForm = that.closest('form');
        var loc = thisForm.find('.realestate_search_location').val();
        url = updateQueryStringParameter(thisForm.attr('action'), 'location', loc);
        window.location.href = url;
    });
    
    $('.galleryimg').gallerybox();
    $('.featuresimg').gallerybox();
    //Login and forgot password Show/Hide
    $('.forgot-pass-link').click(function () {
        $('.full-login-box').slideUp();
        $('.forgot-password-box').slideDown();
    });
    $('.forgot-pass-click-here').click(function () {
        $('.full-login-box').slideDown();
        $('.forgot-password-box').slideUp();
    });


    //Listing Slider
    $("#owl-demo").owlCarousel({
        items: 4,
        navigation: true,
        navigationText: ["<i class='fa fa-long-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>"],
    });
    
    $("#owl-demo-agency").owlCarousel({
        items: 5,
        navigation: true,
        slideBy:5,
        navigationText: ["<i class='fa fa-angle-double-left' aria-hidden='true'></i> Prev 5", "Next 5 <i class='fa fa-angle-double-right' aria-hidden='true'></i>"],
    });
    
    //Listing Slider
    $("#newest-listings-buy").owlCarousel({
        items: 4,
        navigation: true,
        navigationText: ["<i class='fa fa-long-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>"],
    });
    
    
    $("#home-listings-buy").owlCarousel({
        items: 4,
        navigation: true,
        navigationText: ["<i class='fa fa-long-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>"],
    });
    //owlCarousel

    $("#luxury-listings-buy").owlCarousel({
            items : 2,
            navigation : true,
            navigationText : ["<i class='fa fa-long-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>"],
            itemsDesktop : [1199, 2],
            itemsDesktopSmall : [979, 1],
            itemsTablet : [768, 1],
    });

    $("#affordable-listings-buy").owlCarousel({
            items : 2,
            navigation : true,
            navigationText : ["<i class='fa fa-long-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>"],
            itemsDesktop : [1199, 2],
            itemsDesktopSmall : [979, 1],
            itemsTablet : [768, 1],
    });
    
    $("#news-feed-list").owlCarousel({
        items : 4,
        navigation : true,
        navigationText : ["<i class='fa fa-long-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>"],
        itemsDesktop : [1199, 2],
        itemsDesktopSmall : [979, 1],
        itemsTablet : [768, 1],
    });
    
    //Listing Slider
    $("#rental-pools").owlCarousel({
        items: 4,
        navigation: true,
        navigationText: ["<i class='fa fa-long-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>"],
    });
    
    $("#pet-friendly").owlCarousel({
        items: 4,
        navigation: true,
        navigationText: ["<i class='fa fa-long-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>"],
    });
    
    $("#homes-rental").owlCarousel({
        items: 4,
        navigation: true,
        navigationText: ["<i class='fa fa-long-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>"],
    });
    
    $("#studio-rental").owlCarousel({
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

    //Property Search window height
    var windowHeight = $(window).innerHeight();
    var headerHeight = $('.mainheader').height();
    var menuHeight = $('.property-menu-bar').height();
    //$('.property-search-sec, .property-search-map, .property-search-right-sec').css('height', ((windowHeight - (headerHeight + menuHeight)) - 10) + 'px' )
    $('.property-search-sec, .property-search-map').css('height', ((windowHeight - (headerHeight + menuHeight)) - 10) + 'px')
	
	var propertyHeight = $('.property-menu-bar').height();
	$('.property-menu-bar').after('<div class="property-menu-bar-inner"></div>');
	//alert(propertyHeight);
	$('.property-menu-bar-inner').css('height', propertyHeight + 'px')
	
    //slimscroll
    $('.property-search-tabbar-sec .property-search-listing-sec').slimscroll({
        //size: '15px'
        alwaysVisible: true,
        height: '400px',
    });

    //News Carousel
    $('.carousel .vertical .item').each(function () {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i = 1; i < 2; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));
        }
    });
    
    
    
    $('body').on('submit', '.frm_newsletter_subscribe', function (e) {
        var postData = $(this).serialize();
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url: postUrl,
            type: "POST",
            //cache : false,
            data: postData,
            dataType: 'json',
            success: function (resp) {
                if (resp.success == true) {
                    resetFormVal('frm_newsletter_subscribe', 0);
                    $('.emailCls').val('');
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function () {
                        $('#sucMsgDiv').fadeOut('slow');
                    }, 3000);
                    //setTimeout(function(){ window.location = resp.redirect_url }, 5000);
                } else {
                    var msg = first(resp.errors);
                    $('.failmsgdiv').html(msg);
                    $('#failMsgDiv').show('slow');
                    setTimeout(function () {
                        $('#failMsgDiv').fadeOut('slow');
                    }, 3000);
                }
            },
            error: function (xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    $('body').on('submit', '.contact-form', function (e) {
        var postData = $(this).serialize();
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url: postUrl,
            type: "POST",
            //cache : false,
            data: postData,
            dataType: 'json',
            success: function (resp) {
                if (resp.success == true) {
                    $('.emailCls').val('');
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    //setTimeout(function(){ window.location = resp.redirect_url }, 5000);
                } else {
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                }
            },
            error: function (xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    $('body').on('submit', '.private-request-form', function (e) { 
        $.loading();
        var postData = $(this).serialize();
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url: postUrl,
            type: "POST",
            //cache : false,
            data: postData,
            dataType: 'json',
            success: function (resp) {
                $.loaded();
                $(".error-message").remove();
                if (resp.success == true) {
                    $('.error-message').remove();
                    $('.emailCls').val('');
                    $('.txt_field').val('');
                    $('.reqsucmsgdiv').html(resp.message);
                    $('#reqSucMsgDiv').show('slow');
                    setTimeout(function (){$('#reqSucMsgDiv').fadeOut('slow');},3000);
                } else { 
                    $('.reqfailmsgdiv').html(resp.message);
                    if(resp.errors.name){
                        $('#propertyshowingrequest-name').after("<div class='error-message'>"+resp.errors.name+"</div>");
                    }
                    if(resp.errors.email){
                        $('#propertyshowingrequest-email').after("<div class='error-message'>"+resp.errors.email+"</div>")   ;
                    }
                    if(resp.errors.phone){
                        $('#propertyshowingrequest-phone').after("<div class='error-message'>"+resp.errors.phone+"</div>")   ;
                    }
                    if(resp.errors.schedule){
                        $('#propertyshowingrequest-schedule').after("<div class='error-message'>"+resp.errors.schedule+"</div>")   ;
                    }
                    $('#reqFailMsgDiv').show('slow');
                    setTimeout(function (){$('#reqFailMsgDiv').fadeOut('slow');},3000);
                }
            },
            error: function (xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    $('body').on('submit', '.contact-agent-form', function (e) { 
       // $.loading();
        var postData = $(this).serialize();
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url: postUrl,
            type: "POST",
            //cache : false,
            data: postData,
            dataType: 'json',
            success: function (resp) {
               // $.loaded();
                $(".error-message").remove();
                if (resp.success == true) {
                    $('.error-message').remove();
                    $('.emailCls').val('');
                    $('.txt_field').val('');
                    $('.reqsucmsgdiv').html(resp.message);
                    $('#reqSucMsgDiv').show('slow');
                    setTimeout(function (){$('#reqSucMsgDiv').fadeOut('slow');},3000);
                } else { 
                    $('.reqfailmsgdiv').html(resp.message);
                    if(resp.errors.name){
                        $('#contactagent-name').after("<div class='error-message'>"+resp.errors.name+"</div>");
                    }
                    if(resp.errors.email){
                        $('#contactagent-email').after("<div class='error-message'>"+resp.errors.email+"</div>")   ;
                    }
                    if(resp.errors.phone){
                        $('#contactagent-phone').after("<div class='error-message'>"+resp.errors.phone+"</div>")   ;
                    }
                    $('#reqFailMsgDiv').show('slow');
                    setTimeout(function (){$('#reqFailMsgDiv').fadeOut('slow');},3000);
                }
            },
            error: function (xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
        $('#mls_bs_modal_one').off('hidden.bs.modal'); 
    });
    
    $('#mls_bs_modal_two').on('shown.bs.modal', function (e) {
        $('#mls_bs_modal_two').off('hidden.bs.modal');
    });
    
    $(document).on('hidden.bs.modal', '#mls_bs_modal_one', function (e) { 
        if (typeof $(e.target).data('noremote') != 'undefined') {
            return true;
        }
        $(e.target).removeData('bs.modal');
        $(e.target).find('.modal-content').html(''); 
    });
    
    $(document).on('hidden.bs.modal', '#mls_bs_modal_two', function (e) {
        if (typeof $(e.target).data('noremote') != 'undefined') {
            return true;
        }
        $(e.target).removeData('bs.modal');
        $(e.target).find('.modal-content').html(''); 
    });
    
	
    $(document).on('click', '.lnk_signup' ,function (e) {
        var thisLink = $(this);
        $('#mls_bs_modal_one').modal('hide');
        $('#mls_bs_modal_one').on('hidden.bs.modal', function (e) {
            $('#mls_bs_modal_two').modal({remote: thisLink.data('href')});
        });
    });
	
    $(document).on('click', '.lnk_login' ,function (e) {
        var thisLink = $(this);
        $('#mls_bs_modal_two').modal('hide');
        $('#mls_bs_modal_two').on('hidden.bs.modal', function (e) {
            $('#mls_bs_modal_one').modal({remote: thisLink.data('href')});
        });
    });
	
    $(document).on('click', '.btn_add_package_booking_info', function () {
        var localInfoRowHtml = $('.dv_package_booking_block_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.dv_package_booking_info_container').append(localInfoRowHtml);
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

function first(obj) {
    for (var a in obj)
        return obj[a];
}
$(window).scroll(function () {
    if ($(this).scrollTop() > 650) {
        //$('.scroll-top-sec').show();
        $('.scroll-top-sec').addClass("headerstuck");
    }
    else {
        $('.scroll-top-sec').removeClass("headerstuck");
    }
});

$(document).ready(function () {
    //slimscroll
    $('.location-left-tab').slimscroll({
        //size: '15px'
        distance: '5px',
        alwaysVisible: true,
        height: '346px',
    });
    
    $('.features-more').click(function(){
        $(this).prev('.features-listing-sub').slideDown();
        $(this).hide();
        $(this).next(".features-less").show();
    });
    $('.features-less').click(function(){
        $(this).prev('.features-more').prev('.features-listing-sub').slideUp();
        $(this).hide();
        $(this).prev(".features-more").show();
    });
    

    $(".show-more-properties").click(function () {
        $(this).prev(".active-sold-table-listing").addClass("show-active-sold-table-listing");
        $(this).hide();
        $(this).next(".less-more-properties").show();
    });
    $(".less-more-properties").click(function () {
        $(this).prev(".show-more-properties").prev(".active-sold-table-listing").removeClass("show-active-sold-table-listing");
        $(this).hide();
        $(this).prev(".show-more-properties").show();
    });

    $(".show-more-Price").click(function () {
        $(this).prev(".average-price-table-listing").addClass("show-average-price-table-listing");
        $(this).hide();
        $(this).next(".less-more-Price").show();
    });
    $(".less-more-Price").click(function () {
        $(this).prev(".show-more-Price").prev(".average-price-table-listing").removeClass("show-average-price-table-listing");
        $(this).hide();
        $(this).prev(".show-more-Price").show();
    });

});

$(document).ready(function () {
    $(document).on("scroll", onScroll);

    //smoothscroll
    $('.smoothscrollproperty').on('click', function (e) {
        e.preventDefault();
        $(document).off("scroll");

        $('.smoothscrollproperty').each(function () {
            $(this).removeClass('active');
        })
        $(this).addClass('active');

        var target = this.hash,
                menu = target;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top - ($(".headerstuck").outerHeight(true) + 20)
        }, 500, 'swing', function () {
           // window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });
    
    $('.bnt_save_comment').on('click', function(){ 
        $('#frm_blog_comment_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_blog_comment_data',0);
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
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
 $(document).ready(function() {
    $('.more-menu-link').click(function(){
        $(this).prev('.more-menu').slideDown();
        $(this).hide();
        $(this).next(".less-menu-link").show();
    });
    $('.less-menu-link').click(function(){
        $(this).prev('.more-menu-link').prev('.more-menu').slideUp();
        $(this).hide();
        $(this).prev(".more-menu-link").show();
    });
    $('body').on('submit', '#contact-form', function(e){
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.loading();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) {
                $.loaded();
//                $('#signup_captcha_image').trigger('click');
                if (resp.success == true){
                    resetFormVal('contact-form',0);
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                }else{
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                
            }
        });
        return false;
    });
    
    $('.btn_sell_estimate').on('click', function(){
        var that = $(this);
        var thisForm = that.closest('form');
        var rentType = thisForm.find('.realestate_search_rent_type').val();
        var loc = thisForm.find('.realestate_search_location').val();
        var addr = thisForm.find('.realestate_search_address').val();
        var minPrice = thisForm.find('.adv_min_price').val();
        var maxPrice = thisForm.find('.adv_max_price').val();
        var bedroom = thisForm.find('.adv_bedroom').val();
        var bathroom = thisForm.find('.adv_bathroom').val();
        var garage = thisForm.find('.adv_garage').val();
        var propType = thisForm.find('.adv_property_type').val();
        var constStatus = thisForm.find('.adv_construction_status').val();
        var marktStatus = thisForm.find('.adv_market_status').val();
        var propertyID = thisForm.find('.adv_propertyid').val();
        
        if(!loc){
            alert('Please select a location');
            thisForm.find('.adventure-search-box').slideUp();
            return false;
        }
        var url = thisForm.attr('action');
        
        var loca = loc.split(', '), state, town, area;
        if(loca.length === 1){
            state = loca[0];
            url = updateQueryStringParameter(url, 'state', state);
        }else if(loca.length === 2){
            town = loca[0];
            state = loca[1];
            url = updateQueryStringParameter(url, 'town', town);
            url = updateQueryStringParameter(url, 'state', state);
        }else if(loca.length === 3) {
            area = loca[0];
            town = loca[1];
            state = loca[2];
            url = updateQueryStringParameter(url, 'area', area);
            url = updateQueryStringParameter(url, 'town', town);
            url = updateQueryStringParameter(url, 'state', state);
        }
        
        var addra = addr.split(', '), streetName, streetNumber, apptUnit;
        if(addra.length === 1){
            streetName = addra[0];
            url = updateQueryStringParameter(url, 'street_address', streetName);
        }else if(addra.length === 2){
            streetNumber = addra[0];
            streetName = addra[1];
            url = updateQueryStringParameter(url, 'street_number', streetNumber);
            url = updateQueryStringParameter(url, 'street_address', streetName);
        }else if(addra.length === 3) {
            streetNumber = addra[0];
            streetName = addra[1];
            apptUnit = addra[2];
            url = updateQueryStringParameter(url, 'street_number', streetNumber);
            url = updateQueryStringParameter(url, 'street_address', streetName);
            url = updateQueryStringParameter(url, 'appartment_unit', apptUnit);
        }
        
        if(rentType){
            url = updateQueryStringParameter(url, 'rent_type', rentType);
        }if(minPrice){
            url = updateQueryStringParameter(url, 'min_price', minPrice);
        }if(maxPrice){
            url = updateQueryStringParameter(url, 'max_price', maxPrice);
        }if(bedroom){
            url = updateQueryStringParameter(url, 'bedroom', bedroom);
        }if(bathroom){
            url = updateQueryStringParameter(url, 'bathroom', bathroom);
        }if(garage){
            url = updateQueryStringParameter(url, 'garage', garage);
        }if(propType){
            url = updateQueryStringParameter(url, 'prop_types', propType);
        }if(constStatus){
            url = updateQueryStringParameter(url, 'const_status', constStatus);
        }if(marktStatus){
            url = updateQueryStringParameter(url, 'market_statuses', marktStatus);
        }if(propertyID){
            url = updateQueryStringParameter(url, 'property_id', propertyID);
        }
 
        window.location.href = url;
    });
       
});
function onScroll(event) {
    var scrollPos = $(document).scrollTop();
    $('#menu-center a').each(function () {
        var currLink = $(this);
        var refElement = $(currLink.attr("href"));
        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('#menu-center ul li a').removeClass("active");
            currLink.addClass("active");
        }
        else {
            currLink.removeClass("active");
        }
    });
     $('#rental-menu-center a').each(function () {
        var currLink = $(this);
        var refElement = $(currLink.attr("href"));
        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('#menu-center ul li a').removeClass("active");
            currLink.addClass("active");
        }
        else {
            currLink.removeClass("active");
        }
    });
    
}

function kFormatter(num) {
    return num >= 1000000 ? 'N'+ (num/1000000).toFixed(0) + 'M' : (num > 999? 'N'+ (num/1000).toFixed(0) + 'k': 'N'+ num)
}

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

function updateQueryStringParameter(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    return uri + separator + key + "=" + value;
  }
}

/**
 * 
 * @param {type} min
 * @param {type} max
 * @returns {String}
 */
function getPriceButtonText(min, max){
    var btnText = 'Any Price';
    var minText = 'No Min', maxText = 'No Max';
    if(min){
        minText = kFormatter(min);
    }
    if(max){
        maxText = kFormatter(max);
    }
    if(min || max){
        btnText = minText+ '-'+ maxText;
    }
    return btnText;
}