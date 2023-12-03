@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection
@section('content')


    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5" style="flex: 1">
        <h3 class="fw-bolder pageTitle">Responding Incident Reports</h3>

        <div class="requests row justify-content-around" style="width: 95%; margin: 10px">
                <div class="col-sm-8 col-md-5 shadow p-4 mb-4 bg-white rounded " >
                    <h5 class="fw-bold" style="color: #D2AC76">Received Incident Report</h5>

                    <div class="row align-items-center">
                        <div class="col">
                        <div class="col" id="ResReportCont">
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="respondingreportModal1" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                    <h4 style="text-align: center">Incident Report</h4>                                        
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="respondingreportModal1Body">
                                    
                                    </div>
                                    

                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="respondingreportModal1Footer">
                                        
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        
                        </div>             
                    </div>
                </div>
            
                <div class="col-sm-4 col-md-5 shadow p-4 mb-4 bg-white rounded " >
                <h5 class="fw-bold" style="color: #D2AC76">Incident Report</h5>

                <div class="row align-items-center">
                    <div class="col">
                    <div class="col" id="getRespondingReportCont">
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="respondingreportModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                    <h4 style="text-align: center">Incident Report</h4>                                        
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="resreportModalBody">
                                    
                                    </div>
                                    

                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="resreportModalFooter">
                                        
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                </div>
                </div>

            </div>
        </div>
    </div>

    


    

 
    <script>
    // Array to store map instances
    var maps = [];

function initMaps() {
    @foreach ($respondIncident as $report)
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
@section('pageJs')
<script src="{{ asset('js/repondreport.js')}}"></script>
@endsection




@endsection