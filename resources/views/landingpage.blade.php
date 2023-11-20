@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
@endsection
@section('content')
<body class="container flex-row" >

    @include('sidebar.sidenav')
   
    <div class="landing-container p-4 " >
    <h1>Dashboard</h1>

            <div class="row justify-content-around text-center" style="width: 100%">
                <div class="col-sm-4 shadow p-4 mb-4 bg-white rounded " style="width: 20%; margin: 10px">
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="bi bi-exclamation-triangle h1"></i>
                                </div>
                                <div class="col">
                                    <h1 class="fw-normal ">{{$pendingCount}}</h1>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-sm-4 shadow p-4 mb-4 bg-white rounded " style="width: 20%; margin: 10px">
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="bi bi-arrow-repeat h1"></i>
                                </div>
                                <div class="col">
                                    <h1 class="fw-normal ">{{$respondingCount}}</h1>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-sm-4 shadow p-4 mb-4 bg-white rounded " style="width: 20%; margin: 10px">
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                <i class="bi bi-send-exclamation h1"></i>
                                </div>
                                <div class="col">
                                    <h1 class="fw-normal ">{{$forwardedCount}}</h1>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-sm-4 shadow p-4 mb-4 bg-white rounded " style="width: 20%; margin: 10px">
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="bi bi-check-circle h1"></i>
                                </div>
                                <div class="col">
                                    <h1 class="fw-normal ">{{$completedCount}}</h1>
                                </div>
                            </div>
                        </div>
                </div>

            </div>

            <div class="row justify-content-center" style="width: 100%;">
                <div class="col-sm-8 shadow p-4 mb-4 bg-white rounded " style="width: 50%; margin: 10px">
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="fw-normal ">Graph</h4>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-sm-4 shadow p-4 mb-4 bg-white rounded " style="width: 40%; margin: 10px">
                <h4 class="fw-normal">Latest Request</h4>
                @foreach($pendingIncidents as $incident)
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    
                                   
                                    <!-- Latest Request -->
                                    <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$incident->id}}" style="width: 100%; margin: 10px; border: none">
                                        <div class="card-body">
                                                <div class="row align-items-center text-start">
                                                    <div class="col-auto">
                                                        <h1 style="color: red">|</h1>
                                                    </div>
                                                    <div class="col">
                                                        <h4 style="color: #000">{{$incident->type}}</h4>
                                                      
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                </div>
                            </div>
                    </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$incident->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body justify-content-center">
                                    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.app.goo.gl/SsbbLj4qt86JPkPG9"></iframe>
                                    <h4 style="text-align: center">Details</h4>

                                    <div class="square-container p-20">
                                        <div class="shadow p-1 mb-1 bg-white rounded">
                                            <h5>Emergency: {{$incident->type}}</h5>
                                            <h5>Name: {{$incident->user->first_name}} {{$incident->user->last_name}}</h5>
                                            <h5>Age: {{$incident->user->age}}</h5>
                                            <h5>Address:{{$incident->user->lot_no}} {{$incident->user->street}} {{$incident->user->barangay}} {{$incident->user->city}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-success" >Respond</button>
                                    <button type="button" class="btn btn-primary" onclick="forward({{$incident->id}}">Forward</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                
                </div>

            </div>
    </div>
</body>

    


@endsection