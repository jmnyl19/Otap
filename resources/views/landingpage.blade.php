@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
@endsection
@section('content')
<body class="container flex-row">

    @include('sidebar.sidenav')
    <!-- <div class="container d-flex flex-column p-5 ms-5">
        <div class="welcome-container text-container row gap-5 mb-5">
        <div class="welcome-Log col">
            <p class="welcome-title"> Hello, <strong>!</strong></p>
            <p class="welcome-text"> Do you have any concerns you wish to raise to the student council? 
                Submit a <strong> Ticket</strong> to let them know!</p>
        </div>
        <a class="add-ticket col d-flex align-items-center justify-content-center" >
            <p class="color text-center align-middle">Create a Ticket</p>
        </a>
        </div>  

        <div class="welcome-container d-flex flex-row">
        <p class="pe-3 py-1 width"> Analytics </p>
        <p class="col line rounded">  </p>
        </div>

        <div class="welcome-container text-container row gap-5 mb-5">
            <div class="log col p-3">
                <p class="fs fw-bold mb-0"></p>
                <p class="fs-6 mt-0"> Pending Concerns </p>
            </div>

            <div class="log col p-3">
                <p class="fs fw-bold mb-0"></p>
                <p class="fs-6 mt-0"> Concerns Raised </p>
            </div>

            <div class="log col p-3">
                <p class="fs fw-bold  mb-0"></p>
                <p class="fs-6  mt-0"> Concerns Dealt </p>
            </div>
        </div>
        </div>

    </div> -->
    <h1>Dashboard</h1>
    
</body>

    


@endsection