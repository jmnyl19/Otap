function initMap(incidentId, latitude, longitude) {
    // Create a LatLng object with the incident's coordinates
    var incidentLatLng = new google.maps.LatLng(latitude, longitude);
  
    // Create a map centered at the incident's coordinates
    var map = new google.maps.Map(document.getElementById('map' + incidentId), {
      center: incidentLatLng,
      zoom: 15, // Adjust the zoom level as needed
    });
  
    // Create a marker at the incident's coordinates
    var marker = new google.maps.Marker({
      position: incidentLatLng,
      map: map,
      title: 'Incident Location',
    });
  }