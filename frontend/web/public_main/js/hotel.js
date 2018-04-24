function initializeHotelInfo(hotel) { 
//    alert(hotel.lng+','+hotel.lat);
    console.log(hotel.lng+hotel.lat);
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
    map = new google.maps.Map(document.getElementById("hotel_info_map_canvas"), mapOptions);
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
    position = new google.maps.LatLng(hotel.lat, hotel.lng); 
    bounds.extend(position);
    marker = new google.maps.Marker({
        position: position,
        map: map,
        title: hotel.title,
        icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
    });
    // Allow each marker to have an info window    
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
            infoWindow.setContent(infoWindowContent[i]);
            infoWindow.open(map, marker);
        }
    })(marker, i));

    // Allow each marker to have an info window    
    marker.addListener('mouseout', function() {
        directionsDisplay.setMap(null);
    });

    // Automatically center the map fitting all markers on the screen
    map.fitBounds(bounds);
    
    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
//    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
//        this.setZoom(14);
//        google.maps.event.removeListener(boundsListener);
//    });
}