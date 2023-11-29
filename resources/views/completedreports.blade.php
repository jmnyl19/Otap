@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection
@section('content')


    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5" style="flex: 1">
        <h3 class="fw-bolder pageTitle">Completed Incident Reports</h3>

        <div class="requests row justify-content-around" style="width: 95%; margin: 10px">
            <div class="col-sm-8 col-md-5 shadow p-4 mb-4 bg-white rounded " >
                <h5 class="fw-bold" style="color: #D2AC76">Received Incident Report</h5>

                <div class="row align-items-center">
                    <div class="col">
                    @foreach($forwardedReports as $report1)

                    <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$report1->id}}" style="width: 100%; margin: 10px; border: none">
                        <div class="card-body">
                            <div class="row align-items-center text-start">
                                <div class="col-auto">
                                    <h1 style="color: red">|</h1>
                                </div>
                                <div class="col">
                                    <h5 style="color: #000">{{$report1->created_at}}</h5>
                                                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                        <div class="modal modal-lg fade" id="exampleModal{{$report1->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body justify-content-center">
                                    <!-- <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.app.goo.gl/SsbbLj4qt86JPkPG9"></iframe> -->
                                    <h4 style="text-align: center">Incident Report</h4>

                                    <div class="square-container p-20">
                                        <div class="shadow p-1 mb-1 bg-white rounded">
                                        <div class="container row ps-5">
                                        <img src="{{asset('file/'.$report1->report->file)}}" class="img-thumbnail mt-3" alt="...">
                                        <form class="row gt-3 gx-3" action="" method="POST">
                                        @csrf
                                        <div class="col-md-6 mt-3">
                                            <label for="inputName" class="form-label mb-0">Name</label>
                                            <input type="text" class="form-control border-2 border-dark-subtle" id="inputName" name="id" value="{{$report1->report->user->first_name}} {{$report1->report->user->last_name}}" aria-label="Disabled input example" disabled readonly>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="inputPhone" class="form-label mb-0 fs-6">Phone Number</label>
                                            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPhone" name="id" value="{{$report1->report->user->contact_no}}" aria-label="Disabled input example" disabled readonly>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="inputPassword4" class="form-label mb-0 fs-6">Date</label>
                                            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="{{$report1->report->datehappened}}" aria-label="Disabled input example" disabled readonly>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="inputAddress" class="form-label mb-0">Location</label>
                                            <div id="map{{$report1->id}}" style="height: 350px;">
                                            </div>                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">Incident Details</label>
                                            <textarea class="form-control border-2 border-dark-subtle align-left" id="exampleFormControlTextarea1"  name="ticket_body" rows="3" aria-label="Disabled input example" disabled readonly>{{$report1->report->details}}</textarea>
                                        </div>
                                        <div class="col-12 mt-3 mb-3">
                                            <label for="inputAddress" class="form-label mb-0">Additional Notes</label>
                                            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="{{$report1->report->addnote}}" aria-label="Disabled input example" disabled readonly>
                                        </div>
                                        
                                        </form>
                                        </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="modal-footer justify-content-right">
                                    <h5><i class="bi bi-check-circle-fill modalIcon"></i>Completed at: {{$report1->report->updated_at}}</h5>
                                </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>             
                </div>
            </div>

            <div class="col-sm-4 col-md-5 shadow p-4 mb-4 bg-white rounded " >
                <h5 class="fw-bold" style="color: #D2AC76">Incident Report</h5>

                <div class="row align-items-center">
                    <div class="col">
                    @foreach($completedIncident as $report)

                    <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$report->id}}" style="width: 100%; margin: 10px; border: none">
                        <div class="card-body">
                            <div class="row align-items-center text-start">
                                <div class="col-auto">
                                    <h1 style="color: red">|</h1>
                                </div>
                                <div class="col">
                                    <h5 style="color: #000">{{$report->created_at}}</h5>
                                                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                        <div class="modal modal-lg fade" id="exampleModal{{$report->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body justify-content-center">
                                    <!-- <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.app.goo.gl/SsbbLj4qt86JPkPG9"></iframe> -->
                                    <h4 style="text-align: center">Incident Report</h4>

                                    <div class="square-container p-20">
                                        <div class="shadow p-1 mb-1 bg-white rounded">
                                        <div class="container row ps-5">
                                        <img src="{{asset('file/'.$report->file)}}" class="img-thumbnail mt-3" alt="...">
                                        <form class="row gt-3 gx-3" action="" method="POST">
                                        @csrf
                                        <div class="col-md-6 mt-3">
                                            <label for="inputName" class="form-label mb-0">Name</label>
                                            <input type="text" class="form-control border-2 border-dark-subtle" id="inputName" name="id" value="{{$report->user->first_name}} {{$report->user->last_name}}" aria-label="Disabled input example" disabled readonly>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="inputPhone" class="form-label mb-0 fs-6">Phone Number</label>
                                            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPhone" name="id" value="{{$report->user->contact_no}}" aria-label="Disabled input example" disabled readonly>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="inputPassword4" class="form-label mb-0 fs-6">Date</label>
                                            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="{{$report->datehappened}}" aria-label="Disabled input example" disabled readonly>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="inputAddress" class="form-label mb-0">Location</label>
                                            <div id="map{{$report->id}}" style="height: 350px;">
                                            </div>                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">Incident Details</label>
                                            <textarea class="form-control border-2 border-dark-subtle align-left" id="exampleFormControlTextarea1"  name="ticket_body" rows="3" aria-label="Disabled input example" disabled readonly>{{$report->details}}</textarea>
                                        </div>
                                        <div class="col-12 mt-3 mb-3">
                                            <label for="inputAddress" class="form-label mb-0">Additional Notes</label>
                                            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="{{$report->addnote}}" aria-label="Disabled input example" disabled readonly>
                                        </div>
                                        
                                        </form>
                                        </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-right">
                                    <h5><i class="bi bi-check-circle-fill modalIcon"></i>Completed at: {{$report->updated_at}}</h5>
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
    @foreach ($completedIncident as $report)
        initMap('map{{$report->id}}', {{$report->latitude}}, {{$report->longitude}}, '{{$report->id}}');
    @endforeach
    @foreach ($forwardedReports as $report1)
        initMap('map{{$report1->report->id}}', {{$report1->report->latitude}}, {{$report1->report->longitude}}, '{{$report1->report->id}}');
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