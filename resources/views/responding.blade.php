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
@php
    use Carbon\Carbon;
@endphp

    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5" style="flex: 1">
        <h3 class="fw-bolder pageTitle mb-4">Responding Emergency</h3>

        <div class="requests row justify-content-around" style="width: 95%; margin: 10px">
            <div class="col-sm-8 col-md-5 shadow p-4 mb-4 bg-white rounded " >
                <div class="row align-items-center">
                    <div class="col">
                    <h5 class="fw-bold" style="color: #D2AC76">Emergency Request</h5>
                    @foreach($respondingIncidents as $incident)
                        @if ($incident->type == 'Requesting for Ambulance')
                            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$incident->id}}" style="width: 100%; margin: 10px; border: none">
                                <div class="card-body">
                                        <div class="row align-items-center text-start">
                                            <div class="col-auto">
                                                <h1 style="color: red">|</h1>
                                            </div>
                                            <div class="col">
                                                <h6 style="color: #000">{{$incident->type}}</h6>
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
                                                <h6 style="color: #000">{{$incident->type}}</h6>
                                            
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
                                                <h6 style="color: #000">{{$incident->type}}</h6>
                                            
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        @endif
                    @endforeach
                    <!-- Modal -->
                    @foreach($respondingIncidents as $incident_modal)
                    <div class="modal fade" id="exampleModal{{$incident_modal->id}}" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content rounded-4 border border-success border-3">
                                <div class="modal-header">
                                    <h5 style="text-align: center"><i class="bi bi-megaphone-fill mr-5 pendingLogo"></i>   Emergency Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                    
                                <div class="modal-body justify-content-center">
                                    <!-- Google Map Container -->
                                    <div id="map{{$incident_modal->id}}" style="height: 350px;">
                                    </div>
                    
                                    <!-- Rest of the modal content -->
                                    <hr class="style-one">
                                    <div class="square-container mt-2 p-20">
                                        <div class="shadow p-3 mb-1 rounded modalInfo">
                                            <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: {{$incident_modal->created_at}}</h5>
                                            <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: {{$incident_modal->type}}</h5>
                                            <h5><i class="bi bi-person-circle modalIcon"></i>Name: {{$incident_modal->user->first_name}} {{$incident_modal->user->last_name}}</h5>
                                            <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: {{$incident_modal->user->age}}</h5>
                                            <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: {{$incident_modal->user->barangay}}</h5>
                                            <h5 id="address{{$incident_modal->id}}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Sepecific Location: </h5>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="modal-footer justify-content-center">
                                    <form action="/completed/{{$incident_modal->id}}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="completeBtn" type="submit">
                                            <div class="svg-wrapper-1">
                                                <div class="svg-wrapper">
                                                    <svg  viewBox="0 0 24 24"
                                                    width="24"
                                                    height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="#ffffff"></path> </g></svg>
                                                </div>
                                            </div>
                                            <span>Mark as Completed</span>
                                            </button>
                                    </form>
                                   
                                </div>
                            </div>
                        </div>
                    </div>


                    @endforeach

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-5 shadow p-4 mb-4 bg-white rounded " >
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="fw-bold" style="color: #D2AC76">Forwarded Emergency Request</h5>
                        @foreach($forwardedIncidents as $incident1)
                            @if ($incident1->incident->type == 'Requesting for Ambulance')
                                <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1{{$incident1->id}}" style="width: 100%; margin: 10px; border: none">
                                    <div class="card-body">
                                            <div class="row align-items-center text-start">
                                                <div class="col-auto">
                                                    <h1 style="color: red">|</h1>
                                                </div>
                                                <div class="col">
                                                    <h6 style="color: #000"><span class="fw-bold">({{Carbon::parse($incident1->created_at)->format('M, j H:ia' )}}) </span>{{$incident1->incident->user->barangay}}:  {{$incident1->incident->barangay}} </h6>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            @elseif ($incident1->incident->type == 'Requesting for a Fire Truck')
                                <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1{{$incident1->id}}" style="width: 100%; margin: 10px; border: none">
                                    <div class="card-body">
                                            <div class="row align-items-center text-start">
                                                <div class="col-auto">
                                                    <h1 style="color: rgb(255, 132, 0)">|</h1>
                                                </div>
                                                <div class="col">
                                                    <h6 style="color: #000"><span class="fw-bold">({{Carbon::parse($incident1->created_at)->format('M, j H:ia' )}}) </span>{{$incident1->incident->user->barangay}}:  {{$incident1->incident->type}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            @else
                                <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1{{$incident1->id}}" style="width: 100%; margin: 10px; border: none">
                                    <div class="card-body">
                                            <div class="row align-items-center text-start">
                                                <div class="col-auto">
                                                    <h1 style="color: rgb(0, 157, 255) ">|</h1>
                                                </div>
                                                <div class="col">
                                                    <h6 style="color: #000"><span class="fw-bold">({{Carbon::parse($incident1->created_at)->format('M, j H:ia' )}}) </span>{{$incident1->incident->user->barangay}}:   {{$incident1->incident->type}}</h6>
                                                
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            @endif                            
                        @endforeach

                        <!-- Modal -->
                        @foreach($forwardedIncidents as $incident_modal1)
                            <div class="modal fade" id="exampleModal1{{$incident_modal1->id}}" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-4 border border-success border-3">
                                        <div class="modal-header">
                                            <h5 style="text-align: center"><i class="bi bi-megaphone-fill mr-5 pendingLogo"></i>   Emergency Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                            
                                        <div class="modal-body justify-content-center">
                                            <!-- Google Map Container -->
                                            <div id="map{{$incident_modal1->incident->id}}" style="height: 350px;">
                                            </div>
                            
                                            <!-- Rest of the modal content -->
                                            <hr class="style-one">
                                            <div class="square-container mt-2 p-20">
                                                <div class="shadow p-3 mb-1 rounded modalInfo">
                                                    <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: {{Carbon::parse($incident1->incident->created_at)->format('M, j H:ia' )}}</h5>
                                                    <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: {{$incident_modal1->incident->type}}</h5>
                                                    <h5><i class="bi bi-person-circle modalIcon"></i>Name: {{$incident_modal1->incident->user->first_name}} {{$incident_modal1->incident->user->last_name}}</h5>
                                                    <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: {{$incident_modal1->incident->user->age}}</h5>
                                                    <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: {{$incident_modal1->incident->user->barangay}}</h5>
                                                    <h5 id="address{{$incident_modal1->id}}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer justify-content-center">
                                            <form action="/forcompleted/{{$incident_modal1->id}}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="completeBtn" type="submit">
                                                    <div class="svg-wrapper-1">
                                                        <div class="svg-wrapper">
                                                            <svg  viewBox="0 0 24 24"
                                                            width="24"
                                                            height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="#ffffff"></path> </g></svg>
                                                        </div>
                                                    </div>
                                                    <span>Mark as Completed</span>
                                                    </button>
                                            </form>
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
    @foreach ($respondingIncidents as $incident_modal)
        initMap('map{{$incident_modal->id}}', {{$incident_modal->latitude}}, {{$incident_modal->longitude}}, '{{$incident_modal->id}}');
    @endforeach
    @foreach ($forwardedIncidents as $incident_modal1)
        initMap('map{{$incident_modal1->incident->id}}', {{$incident_modal1->incident->latitude}}, {{$incident_modal1->incident->longitude}}, '{{$incident_modal1->id}}');
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