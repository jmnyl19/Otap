const googleMapsScript = document.createElement('script');
googleMapsScript.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyB3sNbXeLLaZQcJiCWNzC4Rwp-xALyV4lM&callback=initMap`;
googleMapsScript.defer = true;
googleMapsScript.async = true;
var bootstrap = $.noConflict();
document.head.appendChild(googleMapsScript);

function initMap(incidentId, latitude, longitude) {
    const incidentLocation = { lat: latitude, lng: longitude };
    const map = new google.maps.Map(document.getElementById(`map${incidentId}`), {
        zoom: 15,
        center: incidentLocation
    });
    const marker = new google.maps.Marker({
        position: incidentLocation,
        map: map
    });
}

