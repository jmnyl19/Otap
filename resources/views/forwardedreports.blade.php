@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
Forward
@endsection

@section('content')


    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5">
        <h3 class="fw-bolder pageTitle">Forwarded Incident Reports</h3>

        <div class="requests" style="width: 95%; margin: 10px">
            <div class="shadow p-4 mb-4 bg-white rounded " >
                <div class="row align-items-center">
                    <div class="col">

                        <div class="col" id="reportForwarded">
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="reportsForModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                    <h4 style="text-align: center">Incident Report</h4>                                        
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="reportsForModalBody">
                                    
                                    </div>
                                    

                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="reportsForModalFooter">
                                        
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                  

                        <div class="col" id="reportForwarded1">
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="reportsForModal1" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                    <h4 style="text-align: center">Incident Report</h4>                                        
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="reportsForModal1Body">
                                    
                                    </div>
                                    

                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="reportsForModal1Footer">
                                        
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
<script src="{{ asset('js/forwardedreports.js')}}"></script>
@endsection



@endsection