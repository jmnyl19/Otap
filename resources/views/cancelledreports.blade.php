@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
Cancelled
@endsection

@section('content')
@section('js')
<script src="{{ asset('path/to/maps.js') }}"></script>

@endsection

    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5" style="flex: 1">
        <h3 class="fw-bolder pageTitle">Cancelled Incident Reports</h3>
        <div class="d-flex flex-row-reverse" style="width: 95%; margin: 10px">
            <!-- <div id="excelreportButton" ></div> -->
        </div>
        <div class="requests  justify-content-around" style="width: 95%; margin: 10px">
           

            <div class="shadow p-4 mb-4 bg-white rounded " >
                <h5 class="fw-bold" style="color: #D2AC76">Incident Report</h5>

                <div class="row align-items-center">
                    <div class="col">
                    <div class="col" id="cancelledReports">
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="cancelledReportsModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                    <h4 style="text-align: center">Incident Report</h4>                                        
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="cancelledReportsModalBody">
                                    
                                    </div>
                                    

                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="cancelledReportsModalFooter">
                                        
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                </div>
                </div>

            </div>
        </div>
    </div>
    <div class="paginationCont d-flex justify-content-center align-items-center mb-2" style="width: 100%;">
        <div id="pagination"></div>
    </div>
    



@section('pageJs')
<script src="{{ asset('js/cancelledreports.js')}}"></script>

@endsection




@endsection