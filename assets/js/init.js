function initialize(){

  	var locations = location_marker;

    map = new google.maps.Map(document.getElementById('googleMap'), {
      zoom: Number(map_options[0][0]),
      scrollwheel: map_options[0][1],
      center: new google.maps.LatLng(center_at[0], center_at[1]),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      disableDefaultUI: map_options[0][2],
      styles: window[map_options[0][3]]

    });	

    var infowindow = new google.maps.InfoWindow({maxWidth: 250});

    var marker, i;

    for (i = 0; i < locations.length; i++) { 

      var latlng = new google.maps.LatLng(locations[i][0], locations[i][1]);

      
        marker = new google.maps.Marker({
          position: latlng,
          map: map //remove if offset is taking place        
        });       
      

      marker.setIcon(locations[i][10]);      

      if (locations[i][8] == 'yes') {	   
          var marker_animation = locations[i][11];

        	marker.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);

          if (marker_animation == "BOUNCE"){
            marker.setAnimation(google.maps.Animation.BOUNCE);
          };
        	if (marker_animation == "DROP"){
            marker.setAnimation(google.maps.Animation.DROP);
          };       	

        };


      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(
            '<strong>' + locations[i][2] + '</strong>' + '</br>' + 
            locations[i][3] + '</br>' + 
            locations[i][4] + ' ' + locations[i][5] + '</br>' + 
            locations[i][6] + '</br>' +            
            '<h6>' + locations[i][9] + '</h6>' + '</br>' + 
            '<a href="'+locations[i][7] + '" class="mm_location_url" target="_blank">Website</a>'

            );
          infowindow.open(map, marker);	          
        }
      })(marker, i));

    }

}

google.maps.event.addDomListener(window, 'load', initialize);


