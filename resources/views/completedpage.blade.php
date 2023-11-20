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
        <h1>Completed Emergency</h1>

        <div class="requests" style="width: 95%; margin: 10px">
            <div class="shadow p-4 mb-4 bg-white rounded " >
                <div class="row align-items-center">
                    <div class="col">
                    @foreach($completedIncidents as $incident)
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
                    @foreach($completedIncidents as $incident_modal)
                    <div class="modal fade" id="exampleModal{{$incident_modal->id}}" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg ">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                    
                                <div class="modal-body justify-content-center">
                                    <!-- Google Map Container -->
                                    <div id="map{{$incident_modal->id}}" style="height: 300px;"></div>
                    
                                    <!-- Rest of the modal content -->
                                    <h4 style="text-align: center">Details</h4>
                                    <div class="square-container p-20">
                                        <div class="shadow p-1 mb-1 bg-white rounded">
                                            <h5>Emergency: {{$incident_modal->type}}</h5>
                                            <h5>Name: {{$incident_modal->user->first_name}} {{$incident_modal->user->last_name}}</h5>
                                            <h5>Age: {{$incident_modal->user->age}}</h5>
                                            <h5>Address: {{$incident_modal->user->lot_no}} {{$incident_modal->user->street}} {{$incident_modal->user->barangay}} {{$incident_modal->user->city}}</h5>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Respond</button>
                                    <button type="button" class="btn btn-primary" onclick="raised()">Forward</button>

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
        @foreach ($completedIncidents as $incident_modal)
            initMap('map{{$incident_modal->id}}', {{$incident_modal->latitude}}, {{$incident_modal->longitude}});
        @endforeach
    }

    function initMap(mapId, latitude, longitude) {
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
    }
</script>

<!-- Call the initMaps function once the Google Maps API is loaded -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3sNbXeLLaZQcJiCWNzC4Rwp-xALyV4lM&callback=initMaps"></script>



@endsection