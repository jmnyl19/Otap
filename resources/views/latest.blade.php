@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
@endsection
@section('content')
<body class="container flex-row">

    @include('sidebar.sidenav')
    <h1>Latest Incidents</h1>
</body>

    


@endsection