
// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

function initAutocomplete() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 51.211, lng: 4.406},
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('place-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });
    
    var markers = [];
    
    //basic marker
    var latitude = parseFloat(document.getElementById("latitude").value);
    var longitude = parseFloat(document.getElementById("longitude").value);
    console.log(latitude + "   " + longitude);
    var basicLatLng = {lat: latitude, lng: longitude};
    var basicMarker = new google.maps.Marker({
        position: basicLatLng,
        map: map,
        title: 'Hello World!',
        draggable: true
      });
    
    basicMarker.setMap(map);
    
    markers.push(basicMarker);
    
    
    searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

        if (places.length == 0) {
          return;
        }
        
        // Clear out the old markers.
        markers.forEach(function(marker) {
          marker.setMap(null);
        });
        markers = [];
        
        
        markers.push(new google.maps.Marker({
            map: map,
            title: places[0].name,
            position: places[0].geometry.location,
            draggable: true
          }));
        
        map.setZoom(15);
        map.panTo(markers[0].position);
        
        $("#latitude").val(places[0].geometry.location.lat().toFixed(5));
        $("#longitude").val(places[0].geometry.location.lng().toFixed(5));
        
        listenToMarkerDrag(markers[0]);
        
    });

    listenToMarkerDrag(markers[0]);

}


//to prevent submitting the form when hitting enter on the google maps search
$('#edit_project_form').on('submit', function(){
    if ($('input:focus').length){return false;}
});


function listenToMarkerDrag(marker) {
    //on dragend -> get new address + get new coordinates
    google.maps.event.addListener(marker, 'dragend', function (evt) {
        //de coördinaten moeten in hidden inputs gestoken worden
        $("#latitude").val(evt.latLng.lat().toFixed(5));
        $("#longitude").val(evt.latLng.lng().toFixed(5));

        //het nieuwe adres moet in de search input worden weergegeven
        $.getJSON( "https://maps.googleapis.com/maps/api/geocode/json?latlng="+evt.latLng.lat().toFixed(3) + ","+evt.latLng.lng().toFixed(3), function( data ) {
            //console.log(data.results[0].formatted_address);
            $("#place-input").val(data.results[0].formatted_address);
        });
    });
}



