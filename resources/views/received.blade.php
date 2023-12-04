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
        <h3 class="fw-bolder pageTitle mb-4">Recieved Emergency</h3>

        <div class="requests" style="width: 95%; margin: 10px">
            <div class="shadow p-4 mb-4 bg-white rounded " >
                <div class="row align-items-center">
                    <div class="col">
                    <div class="col" id="allReceivedCont">
                        </div>
                    <!-- Modal -->
                    <div class="modal fade"  id="receivedModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-4 border border-success border-3">
                                        <div class="modal-header">
                                            <h5 style="text-align: center"><i class="bi bi-megaphone-fill mr-5 pendingLogo"></i>   Emergency Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                            
                                        <div class="modal-body justify-content-center" id="receivedModalBody">
                                            
                                        </div>
                                        

                                            <input type="hidden" name="status" id="incidentStatus" value="Pending">
                                
                                        <div class="modal-footer justify-content-center" id="receivedModalFooter">
                                            
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
<script src="{{ asset('js/received.js')}}"></script>
@endsection



@endsection