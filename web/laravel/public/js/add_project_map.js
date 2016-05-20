console.log("tesst");

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
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
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

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers.push(new google.maps.Marker({
        map: map,
        title: place.name,
        position: place.geometry.location,
        draggable: true
      }));
        
        //console.log(place.geometry.location.lat());
        //ook hier gaan we de latitude en longitude toevoegen aan de hidden inputs
        $("#latitude").val(place.geometry.location.lat().toFixed(5));
        $("#longitude").val(place.geometry.location.lng().toFixed(5));

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    //dit hieronder ga je doen, zodat er telkens maar 1 marker zichtbaar is, de rest wordt dus niet op de map gezet
    for(var i = 1; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    
    map.fitBounds(bounds);
    
    google.maps.event.addListener(markers[0], 'dragend', function (evt) {
        //de coördinaten moeten in hidden inputs gestoken worden
        $("#latitude").val(evt.latLng.lat().toFixed(5));
        $("#longitude").val(evt.latLng.lng().toFixed(5));
    //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        
        //het nieuwe adres moet in de search input worden weergegeven
        $.getJSON( "https://maps.googleapis.com/maps/api/geocode/json?latlng="+evt.latLng.lat().toFixed(3) + ","+evt.latLng.lng().toFixed(3), function( data ) {
            //console.log(data.results[0].formatted_address);
            $("#place-input").val(data.results[0].formatted_address);
        });
});

google.maps.event.addListener(markers[0], 'dragstart', function (evt) {
    //document.getElementById('current').innerHTML = '<p>Currently dragging marker...</p>';
});
    
    
  });
}

//to prevent submitting the form when hitting enter on the google maps search
$('#add_project_form').on('submit', function(){
    if ($('input:focus').length){return false;}
});



