@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
@endsection
@section('content')
<body class="container flex-row">

    @include('sidebar.sidenav')
    <h1>tapinac admin</h1>
</body>

    


@endsection