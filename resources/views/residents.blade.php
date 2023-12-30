@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
Manage Registered Residents
@endsection

@section('content')
@section('js')
<script src="{{ asset('path/to/maps.js') }}"></script>
<script src="{{ asset('js/sidenav.js') }}"></script>

@endsection


    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5" style="flex: 1">
        <h3 class="fw-bolder pageTitle mb-4">Registered Residents</h3>
        
        <div class="requests" style="width: 95%; margin: 10px">
            <div class="shadow p-4 mb-4 bg-white rounded " >
                <div class="row p-4 align-items-center">
                    
                    <table class="table" id="allResidentsCont">
                        <thead>
                            <tr>
                                <th scope="col">Fullname</th>
                                <th scope="col">Age</th>
                                <th scope="col">Contact No.</th>
                                <th scope="col">Address</th>
                                <th scope="col">Proof of Residency</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    
                    <div class="modal fade"  id="viewDetails" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                        <h5 style="text-align: center"><i class="bi bi-person-fill-gear mr-5 pendingLogo"></i>Resident's Information</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                    <div class="modal-body justify-content-center" id="receivedModalBody">
                                        
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
    </div>

    
 


@section('pageJs')
<script src="{{ asset('js/residents.js')}}"></script>
@endsection



@endsection