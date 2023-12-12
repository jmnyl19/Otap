@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
Pending
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
        <h3 class="fw-bolder pageTitle mb-4">Pending Request</h3>

        <div class="requests row justify-content-around" style="width: 95%; margin: 10px">
            <div class="col-sm-8 col-md-5 shadow p-4 mb-4 bg-white rounded " >
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="fw-bold" style="color: #D2AC76">Emergency Request</h5>
                        <div class="col" id="allIncidentCont">
                        </div>
                        <!-- Modal -->
                        <div class="modal fade"  id="pendingModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                        <h5 style="text-align: center"><i class="bi bi-megaphone-fill mr-5 pendingLogo"></i>   Emergency Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                    <div class="modal-body justify-content-center" id="pendingModalBody">
                                        
                                    </div>
                                    
                                        <div class="modal-body">
                                                <!-- Dropdown -->
                                                <div class="form-group">
                                                    <div class="form-group">

                                                        <label for="forwardDropdown">Forward this Emergency?</label>
                                                        <select class="form-control" id="forwardDropdown" name="barangay">
                                                            
                                                            <option value="" selected disabled>Choose a Barangay:</option>
                                                            <option value="East Tapinac">East Tapinac</option>
                                                            <option value="Santa Rita">Santa Rita</option>
                                                        </select>
                                                    </div>
                                                    
                                            </div>
                                        </div>

                                        <input type="hidden" name="status" id="incidentStatus" value="Pending">
                            
                                    <div class="modal-footer justify-content-center" id="pendingModalFooter">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                 </div>
            </div>

            <div class="col-sm-4 col-md-5 shadow p-4 mb-4 bg-white rounded " >
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="fw-bold" style="color: #D2AC76">Forwarded Emergency Request</h5>
                        <div class="col" id="allForIncidentCont">
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="pendingModal1" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                        <h5 style="text-align: center"><i class="bi bi-megaphone-fill mr-5 pendingLogo"></i>   Emergency Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="pendingModal1Body">
                                    
                                    </div>
                                    

                                    <div class="modal-body">
                                            <!-- Dropdown -->
                                        <div class="form-group">
                                                <div class="form-group">

                                                    <label for="forwardDropdown1">Forward this Emergency?</label>
                                                    <select class="form-control" id="forwardDropdown1" name="barangay">
                                                        
                                                        <option value="" selected disabled>Choose a Barangay:</option>
                                                        <option value="East Tapinac">East Tapinac</option>
                                                        <option value="Santa Rita">Santa Rita</option>
                                                    </select>
                                                </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="pendingModal1Footer">
                                        
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                 </div>
            </div>
        </div>
    </div>

    



@section('pageJs')
<script src="{{ asset('js/pending.js') }}"></script>
@endsection


@endsection