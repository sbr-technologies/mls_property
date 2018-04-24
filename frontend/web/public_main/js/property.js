$(function(){
    $('.frm_payment_calculator').on('change', 'input', function(){
        var thisElem = $(this);
        var thisForm = thisElem.closest('form');
        var field = thisElem.data('field');
        thisForm.find('.hid_field_name').val(field);
        thisForm.submit();
    });

    $('.frm_payment_calculator').on('submit', function(){
        var thisForm = $(this);
        $.post(thisForm.attr('action'), thisForm.serialize(), function(response){
            if(response.status === true){
                $('.calc_property_price').val(response.property_price);
                $('.calc_down_payment_percent').val(response.down_payment_percent);
                $('.calc_down_payment_amount').val(response.down_payment_amount);
                
                $('.calc_mortgage_loan_type_percentage').val(response.mortgage_loan_type_percentage);
                $('.calc_pay_monthly_value').val(response.calc_pay_value);
                $('.total_monthly_installment').text(response.total_monthly_installment);
                $('.mortgage_insurance_amount').val(response.mortgage_insurance);
                
                $('.calc_tax_percent').css('width', response.tax_percent + '%');
                $('.calc_pay_value_percent').css('width', response.pay_value_percent + '%');
                $('.calc_insurance_percent').css('width', response.insurance_percent + '%');
                $('.calc_hoa_fees_percent').css('width', response.hoa_fees_percent + '%');
                $('.calc_mortgage_insurance_percent').css('width', response.mortgage_insurance_percent + '%');
            }
        }, 'json');
        return false;
    });

    $(".frm_payment_calculator").on('keydown', 'input', function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    $('body').on('click', function(e) {
        if (!$('.html_marker').is(e.target) && !$('.map-upon-pop').children().is(e.target)){
           $("#xPopup").hide();
        }
    });
    
    
    $(document).on('click', '.save_as_favorite', function(){
        var thisBtn = $(this);
        $.get(thisBtn.data('href'), function(response){
            if(response.status === true){
                if(response.insert === true){
                    thisBtn.find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                }else{
                    thisBtn.find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
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

function printPage(contElement){ 
    var data = $('.'+contElement).html();
    var mywindow = window.open('', 'Property Details', 'height=400,width=800');
    mywindow.document.write('<title>Property Details</title>');
    mywindow.document.write(data);
    

    mywindow.print();
    mywindow.close();
    return true;
}
function initializeSold(items, status) {
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
    var container;
    if(status === 'active'){
        container = 'realestate_view_active_container';
    }else{
        container = 'realestate_view_sold_container';
    }
    var gmap = new google.maps.Map(document.getElementById(container), mapOptions);
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
            if(status === 'active'){
                var popup = document.getElementById('xPopup');
            }else{
                var popup = document.getElementById('xPopupSold');
            }
            popup.innerHTML = tpl({price: price, feature_image: featureImage, detail_url: detailUrl, address: address, bedroom: bedroom, bathroom: bathroom, area: area});
            popup.style.display = 'block';
            popup.style.left = position.x + 200 + 'px';
            popup.style.top = position.y + 150 + 'px';
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
    }
}

function initializeLocalInfo(property, items, typeId) {
    console.log(items);
    var map;
    
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
    //console.log(directionsService);
    
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        scrollwheel: false,
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("local_info_map_canvas"), mapOptions);
    map.setTilt(45);
    
    // Multiple Markers
    var markers = [
        ['London Eye, London', 51.503454,-0.119562],
        ['Palace of Westminster, London', 51.499633,-0.124755]
    ];
                        
    // Info Window Content
    var infoWindowContent = [], position;
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    position = new google.maps.LatLng(property.lat, property.lng);
    bounds.extend(position);
    marker = new google.maps.Marker({
        position: position,
        map: map,
        title: property.title,
        icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
    });
    
    for( i = 0; i < items.length; i++ ) {
        
        if(typeof typeId == 'undefined' || items[i].info_type_id == typeId || 0 == typeId){
            infoWindowContent[i] = '<div class="info_content">' +
                '<h4>'+items[i].title+'</h4>' +
                '<p>'+items[i].description+'</p></div>';

            position = new google.maps.LatLng(items[i].lat, items[i].lng);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: items[i].title,
                icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
            });

            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                return function() {
                    calculateAndDisplayRoute(property, items[i], directionsService, directionsDisplay);
                    directionsDisplay.setMap(map);
//                    directionsDisplay.setMap(map);
                }
            })(marker, i, property));
            
            marker.addListener('mouseout', function() {
                directionsDisplay.setMap(null);
            });

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }
    }
    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
//    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
//        this.setZoom(14);
//        google.maps.event.removeListener(boundsListener);
//    });
}

      function calculateAndDisplayRoute(property, item, directionsService, directionsDisplay) {
        directionsService.route({
          origin: new google.maps.LatLng(property.lat, property.lng),
          destination: new google.maps.LatLng(item.lat, item.lng),
          travelMode: 'DRIVING' //WALKING or DRIVING
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
