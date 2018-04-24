function holidayMapInitialize(item) {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("holiday_package_details_map_canvas"), mapOptions);
//    map.setTilt(45);
        
    // Multiple Markers
    var markers = [
        [item.name + ' : Source', item.source_lat,item.source_lng, 'http://maps.google.com/mapfiles/kml/pal2/icon2.png'],
        [item.name + ' : Destination', item.destination_lat,item.destination_lng, 'http://maps.google.com/mapfiles/kml/pal2/icon5.png']
    ];
                        
    // Info Window Content
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h3>'+item.name + ' : Source'+'</h3>' +
        '<p>'+item.description+'</p>' +        '</div>'],
        ['<div class="info_content">' +
        '<h3>'+item.name + ' : Destination'+'</h3>' +
        '<p>'+item.description+'</p>' +
        '</div>']
    ];
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0],
            icon: markers[i][3],
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

}