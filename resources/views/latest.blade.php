@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection
@section('content')


    @include('sidebar.sidenav')
    <div class="latest-container p-4 mt-5">
        <h3 class="fw-bolder pageTitle">Incident Reports</h3>

        <div class="requests" style="width: 95%; margin: 10px">
            <div class="shadow p-4 mb-4 bg-white rounded " >
                <div class="row align-items-center">
                    <div class="col">
                    @foreach($reportedIncident as $report)

                    <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$report->id}}" style="width: 100%; margin: 10px; border: none">
                        <div class="card-body">
                            <div class="row align-items-center text-start">
                                <div class="col-auto">
                                    <h1 style="color: red">|</h1>
                                </div>
                                <div class="col">
                                    <h5 style="color: #000">{{$report->location}}</h5>
                                                                
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
                                        <img src="..." class="img-thumbnail mt-3" alt="...">
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
                                            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="{{$report->created_at}}" aria-label="Disabled input example" disabled readonly>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="inputAddress" class="form-label mb-0">Location</label>
                                            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="{{$report->location}}" aria-label="Disabled input example" disabled readonly>
                                        </div>
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
                                <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Respond</button>
                                    <button type="button" class="btn btn-primary">Forward</button>
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

    


    


@endsection