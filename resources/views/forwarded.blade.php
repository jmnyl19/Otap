@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection
@section('content')
@section('js')
<script src="{{ asset('path/to/maps.js') }}"></script>
<script src="{{ asset('js/sidenav.js') }}"></script>

@endsection


    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5" style="flex: 1">
        <h3 class="fw-bolder pageTitle mb-4">Forwarded Emergency</h3>

        <div class="requests" style="width: 95%; margin: 10px">
            <div class="shadow p-4 mb-4 bg-white rounded " >
                <div class="row align-items-center">
                    <div class="col">
                    @foreach($forwardedIncidents as $incident)
                        @if ($incident->type == 'Requesting for Ambulance')
                            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$incident->id}}" style="width: 100%; margin: 10px; border: none">
                                <div class="card-body">
                                        <div class="row align-items-center text-start">
                                            <div class="col-auto">
                                                <h1 style="color: red">|</h1>
                                            </div>
                                            <div class="col">
                                                <h6 style="color: #000">{{$incident->incident->type}}</h6>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        @elseif ($incident->type == 'Requesting for a Fire Truck')
                            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$incident->id}}" style="width: 100%; margin: 10px; border: none">
                                <div class="card-body">
                                        <div class="row align-items-center text-start">
                                            <div class="col-auto">
                                                <h1 style="color: rgb(255, 132, 0)">|</h1>
                                            </div>
                                            <div class="col">
                                                <h6 style="color: #000">{{$incident->incident->type}}</h6>
                                            
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        @else
                            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$incident->id}}" style="width: 100%; margin: 10px; border: none">
                                <div class="card-body">
                                        <div class="row align-items-center text-start">
                                            <div class="col-auto">
                                                <h1 style="color: rgb(0, 157, 255) ">|</h1>
                                            </div>
                                            <div class="col">
                                                <h6 style="color: #000">{{$incident->incident->type}}</h6>
                                            
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        @endif
                    @endforeach
                    <!-- Modal -->
                    @foreach($forwardedIncidents as $incident_modal)
                    <div class="modal fade" id="exampleModal{{$incident_modal->id}}" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content rounded-4 border border-success border-3">
                                <div class="modal-header">
                                    <h5 style="text-align: center"><i class="bi bi-megaphone-fill mr-5 pendingLogo"></i>   Emergency Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                    
                                <div class="modal-body justify-content-center">
                                    <!-- Google Map Container -->
                                    <div id="map{{$incident_modal->incident->id}}" style="height: 350px;">
                                    </div>
                    
                                    <!-- Rest of the modal content -->
                                    <hr class="style-one">
                                    <div class="square-container mt-2 p-20">
                                        <div class="shadow p-3 mb-1 rounded modalInfo">
                                            <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: {{$incident_modal->incident->type}}</h5>
                                            <h5><i class="bi bi-person-circle modalIcon"></i>Name: {{$incident_modal->incident->user->first_name}} {{$incident_modal->incident->user->last_name}}</h5>
                                            <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: {{$incident_modal->incident->user->age}}</h5>
                                            <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: {{$incident_modal->incident->user->barangay}}</h5>
                                            <h5 id="address{{$incident_modal->id}}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Sepecific Location: </h5>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="modal-footer justify-content-center">
                                    
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>
    // Array to store map instances
    var maps = [];

function initMaps() {
    @foreach ($forwardedIncidents as $incident_modal)
        initMap('map{{$incident_modal->incident->id}}', {{$incident_modal->incident->latitude}}, {{$incident_modal->incident->longitude}}, '{{$incident_modal->id}}');
    @endforeach
}

function initMap(mapId, latitude, longitude, incidentId) {
    var incidentLocation = { lat: latitude, lng: longitude };
    var map = new google.maps.Map(document.getElementById(mapId), {
        zoom: 18,
        center: incidentLocation
    });
    var marker = new google.maps.Marker({
        position: incidentLocation,
        map: map
    });

    // Store the map instance in the array
    maps.push({ id: mapId, map: map });

    // Reverse geocoding
    var geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(latitude, longitude);

    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                // Display the formatted address in an info window or console.log
                var addressElement = document.getElementById('address' + incidentId);
                addressElement.innerHTML = '<i class="bi bi-house-down-fill modalIcon"></i>Sepecific Location:: ' + results[1].formatted_address;
            } else {
                console.log('No results found');
            }
        } else {
            console.log('Geocoder failed due to: ' + status);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initMaps();
});
</script>

<!-- Call the initMaps function once the Google Maps API is loaded -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3sNbXeLLaZQcJiCWNzC4Rwp-xALyV4lM&callback=initMaps"></script>



@endsection