@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
Complete
@endsection

@section('content')
@section('js')
<script src="{{ asset('path/to/maps.js') }}"></script>

@endsection

    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5" style="flex: 1">
        <h3 class="fw-bolder pageTitle">Completed Incident Reports</h3>

        <div class="requests row justify-content-around" style="width: 95%; margin: 10px">
            <div class="col-sm-8 col-md-5 shadow p-4 mb-4 bg-white rounded " >
                <h5 class="fw-bold" style="color: #D2AC76">Received Incident Report</h5>

                <div class="row align-items-center">
                    <div class="col">
                    <div class="col" id="completedReports1">
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="comReportsModal1" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                    <h4 style="text-align: center">Incident Report</h4>                                        
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="comReportsModal1Body">
                                    
                                    </div>
                                    

                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="comReportsModal1Footer">
                                        
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
                    <div class="col" id="completedReports">
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="comReportsModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                    <h4 style="text-align: center">Incident Report</h4>                                        
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="comReportsModalBody">
                                    
                                    </div>
                                    

                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="comReportsModalFooter">
                                        
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                </div>
                </div>

            </div>
        </div>
    </div>

    


    



<!-- Call the initMaps function once the Google Maps API is loaded -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3sNbXeLLaZQcJiCWNzC4Rwp-xALyV4lM&callback=initMaps"></script>

@section('pageJs')
<script src="{{ asset('js/completedreports.js')}}"></script>

@endsection




@endsection