@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
Incident
@endsection

@section('content')


    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5" style="flex: 1">
        <h3 class="fw-bolder pageTitle mb-4">Latest Incident Reports</h3>

        <div class="requests justify-content-around" style="width: 95%; margin: 10px">
                
                <div class="shadow p-4 mb-4 bg-white rounded " >
                    <h5 class="fw-bold" style="color: #D2AC76">Incident Report</h5>

                    <div class="row align-items-center">
                        <div class="col">
                        
                        <div class="col" id="getReportsCont">
                        </div>

                        <div class="modal fade" id="reportModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                    <h4 style="text-align: center">Incident Report</h4>                                        
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="reportModalBody">
                                    
                                    </div>
                                    

                                    <div class="modal-body">
                                            <!-- Dropdown -->
                                        <div class="form-group">
                                                <div class="form-group">

                                                    <label for="forwardDropdown">Forward this Emergency?</label>
                                                    <select class="form-control" id="forwardDropdown" name="barangay">
                                                        <!-- Add your dropdown options here -->
                                                        <option value="" selected disabled>Choose a Barangay:</option>
                                                        <option value="East Tapinac">East Tapinac</option>
                                                        <option value="Santa Rita">Santa Rita</option>
                                                    </select>
                                                </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="reportModalFooter">
                                        
                                    </div>
                                    
                                    
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
<script src="{{ asset('js/latest.js')}}"></script>
@endsection




@endsection