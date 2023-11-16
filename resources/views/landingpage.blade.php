@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
@endsection
@section('content')
<body class="container flex-row">

    @include('sidebar.sidenav')
    <div class="container d-flex flex-column p-5 ms-5">
        <div class="welcome-container text-container row gap-5 mb-5">
           
                 <p class="welcome-title"> {{auth()->user()->role}} {{auth()->user()->admin_name}} <strong></strong></p>
            
        </div>  

        

        <div class="welcome-container text-container row gap-5 mb-5">
            <div class="log col p-3">
                <p class="fs fw-bold mb-0"></p>
                <p class="fs-6 mt-0"> Latest </p>
            </div>

            <div class="log col p-3">
                <p class="fs fw-bold mb-0"></p>
                <p class="fs-6 mt-0"> Pending </p>
            </div>

            <div class="log col p-3">
                <p class="fs fw-bold  mb-0"></p>
                <p class="fs-6  mt-0"> Responded </p>
            </div>
        </div>
        </div>

    </div>
   
    
</body>

    


@endsection