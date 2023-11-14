@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
@endsection
@section('content')
<body class="container flex-row">

    @include('sidebar.secsidenav')
    
    <h1>Forwarded Emergency</h1>
</body>

    


@endsection