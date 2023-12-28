@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
Unavailable
@endsection

@section('content')


    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5">
        <h3 class="fw-bolder pageTitle">Unavailable Incident Reports</h3>

        <div class="requests" style="width: 95%; margin: 10px">
            <div class="shadow p-4 mb-4 bg-white rounded " >
                <div class="row align-items-center">
                    <div class="col">

                        
                        <h5 class="fw-bold" style="color: #D2AC76">Incident Report</h5>
                        <div class="col" id="reportForwarded1">
                        </div>
                       
                        <!-- Modal -->
                        <div class="modal fade" id="reportsForModal1" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                    <h4 style="text-align: center">Incident Report</h4>                                        
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="reportsForModal1Body">
                                    
                                    </div>
                                    

                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="unavailablereportFooter">
                                        
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
<script src="{{ asset('js/unavailablereports.js')}}"></script>
@endsection



@endsection