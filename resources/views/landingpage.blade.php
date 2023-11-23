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

@auth
    @include('sidebar.sidenav')
   
    <div class="landing-container p-4 mt-5" >
        <div class="row text-center justify-content-between align-items-center gap-3 mb-2" style="width: 100%">
            <div class="col-md-2 col-sm-4  p-4 rounded-3">
                <h3 class="fw-bolder pageTitle">Dashboard</h3>
            </div>
            {{-- <div class=" col-lg-2 col-md-6 col-sm-4 shadow p-4 rounded-5 dateCont">
                <div class="row justify-content-center align-items-center">
                    <div class="col-auto col-md-2">
                        <i class="bi bi-calendar2-week-fill h3"></i>
                    </div>
                    <div class="col-auto col-md-9 mt-2 justify-content-center align-items-center">
                        <h6 id="datetime"></h6>
                    </div>
                </div>
            </div> --}}
        </div>
        

            <div class="row justify-content-around text-center gap-3" style="width: 100%">
                <div class="col-sm-4 col-md-2 shadow p-4 mb-4 bg-white rounded-4" type="button" onclick="window.location='{{route('pendingpage')}}'" style=" margin: 10px">
                    <div class="card-body ">
                        
                            <div class="countLabel">
                                <h4 class="pendingLogo">Pending</h4>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-auto col-md-4">
                                    <i class="bi bi-exclamation-triangle h1 pendingLogo "></i>
                                </div>
                                <div class="col-auto col-md-4 countText">
                                    <h1 class="fw-normal ">{{$pendingCount}}</h1>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-sm-4 col-md-2 shadow p-4 mb-4 bg-white rounded-4" type="button" onclick="window.location='{{route('responding')}}'" style=" margin: 10px">
                    <div class="card-body">
                        <div class="countLabel">
                            <h4 class="respondingLogo">Responding</h4>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                            <div class="row justify-content-center">
                                <div class="col-auto col-md-4">
                                    <i class="bi bi-arrow-repeat h1 respondingLogo"></i>
                                </div>
                                <div class="col-auto col-md-4 countText">
                                    <h1 class="fw-normal ">{{$respondingCount}}</h1>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-sm-4 col-md-2 shadow p-4 mb-4 bg-white rounded-4" type="button" onclick="window.location='{{route('forwarded')}}'" style=" margin: 10px">
                    <div class="card-body">
                        <div class="countLabel">
                            <h4 class="forwardedLogo">Forwarded</h4>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                            <div class="row justify-content-center">
                                <div class="col-auto col-md-4">
                                <i class="bi bi-send-exclamation h1 forwardedLogo"></i>
                                </div>
                                <div class="col-auto col-md-4 countText">
                                    <h1 class="fw-normal ">{{$forwardedCount}}</h1>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-sm-4 col-md-2 shadow p-4 mb-4 bg-white rounded-4" type="button" onclick="window.location='{{route('completedpage')}}'" style=" margin: 10px">
                    <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="countLabel">
                                    <h4 class="completedLogo">Completed</h4>
                                    <i class="bi bi-chevron-right"></i>
                                </div>
                                <div class="col-auto col-md-4 ">
                                    <i class="bi bi-check-circle h1 completedLogo"></i>
                                </div>
                                <div class="col-auto col-md-4  countText">
                                    <h1 class="fw-normal ">{{$completedCount}}</h1>
                                </div>
                            </div>
                        </div>
                </div>

            </div>
            <div class="row justify-content-around" style="width: 100%;">
                <div class="col-sm-8 col-md-6 shadow p-4 mb-4 bg-white rounded-4" style="margin: 10px">
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="fw-normal ">Graph</h4>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-sm-4 col-md-4 shadow p-4 mb-4 bg-white rounded-4" style="margin: 10px">
                
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="fw-bold">Latest Request</h5>
                                    @foreach($pendingIncidents as $incident)
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
                                </div>
                            </div>
                    </div>

                        <!-- Modal -->
                        @foreach ($pendingIncidents as $incident_modal)
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
                                                    <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: {{$incident_modal->type}}</h5>
                                                    <h5><i class="bi bi-person-circle modalIcon"></i>Name: {{$incident_modal->user->first_name}} {{$incident_modal->user->last_name}}</h5>
                                                    <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: {{$incident_modal->user->age}}</h5>
                                                    <h5><i class="bi bi-house-down-fill modalIcon"></i>Address: {{$incident_modal->user->lot_no}} {{$incident_modal->user->street}} {{$incident_modal->user->barangay}} {{$incident_modal->user->city}}</h5>
                                                </div>
                                            </div>
                                        </div>
                            
                                        <div class="modal-footer justify-content-center">
                                            <form action="/respond/{{$incident_modal->id}}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="respondBtn" type="submit">
                                                    <div class="svg-wrapper-1">
                                                      <div class="svg-wrapper">
                                                        <svg viewBox="0 0 24 24"
                                                        width="24"
                                                        height="24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>arrow_repeat [#238]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-222.000000, -7080.000000)" fill="#ffffff"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M174.034934,6926.99996 C173.480532,6926.99996 173.030583,6927.44796 173.030583,6927.99996 L173.030583,6930.99994 L178.052339,6930.99994 C178.606741,6930.99994 179.05669,6930.49994 179.05669,6929.94795 L179.05669,6929.92095 C179.05669,6929.36895 178.606741,6928.99995 178.052339,6928.99995 L175.039285,6928.99995 L175.039285,6927.99996 C175.039285,6927.44796 174.589336,6926.99996 174.034934,6926.99996 M180.988058,6929.99995 C180.487891,6929.99995 180.071085,6930.36694 179.999776,6930.85894 C179.520701,6934.16792 176.319833,6936.61391 172.736308,6935.86392 C170.462456,6935.38792 168.623489,6933.55693 168.145418,6931.29294 C167.32888,6927.42296 170.287699,6923.99998 174.034934,6923.99998 L174.034934,6925.99997 L179.05669,6922.99998 L174.034934,6920 L174.034934,6921.99999 C169.070425,6921.99999 165.157472,6926.48297 166.156802,6931.60494 C166.765439,6934.72392 169.290378,6937.23791 172.42295,6937.8439 C177.169514,6938.7619 181.369712,6935.51592 181.990401,6931.12594 C182.074766,6930.52994 181.591673,6929.99995 180.988058,6929.99995" id="arrow_repeat-[#238]"> </path> </g> </g> </g> </g></svg>
                                                      </div>
                                                    </div>
                                                    <span>Respond</span>
                                                  </button>
                                            </form>
                                            <form action="/forward/{{$incident_modal->id}}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="forwardBtn" type="submit">
                                                    <div class="svg-wrapper-1">
                                                      <div class="svg-wrapper">
                                                        <svg
                                                          xmlns="http://www.w3.org/2000/svg"
                                                          viewBox="0 0 24 24"
                                                          width="24"
                                                          height="24"
                                                        >
                                                          <path fill="none" d="M0 0h24v24H0z"></path>
                                                          <path
                                                            fill="currentColor"
                                                            d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"
                                                          ></path>
                                                        </svg>
                                                      </div>
                                                    </div>
                                                    <span>Forward</span>
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


<!-- Add this script to initialize the maps -->
<script>
    // Array to store map instances
    var maps = [];

    function initMaps() {
        @foreach ($pendingIncidents as $incident_modal)
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


@endauth
@endsection