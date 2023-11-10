@extends('layouts.app')

@section('css')
<link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endsection
@section('content')

<body class="">
    <div id="" class="container">
        <div class="left">
            <div class="left-content">
                <div>
                    <h3>V O X</h3>
                </div>
                <div>
                    <h1 class="fw-normal">Let your voice be <b class="fs-semibold">heard</b></h1>
                    <p class="fs-6">Vox empowers students to shape their education by amplifying their voices. Share your story in this safe space platform and help ensure students are heard and valued.</p>
                </div>
                <div>
                <p>Developed by: </p>
                </div>
            </div>
        </div>
        <div class="right">
            <div>
                <h2 class="color fs-1 fw-bolder">Sign up</h2>
                <p class="fs-6">Have an account? <a href="{{ route('login.show') }}" style="color: #1FAB89; text-decoration: none">Log in</a></p>
            </div>
            <div">
                <form action="{{route('register.perform')}}" method="POST" class="row gy-3 gx-3 align-items-right"> 
                    @csrf
                    <div class="col-md-6" >
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control border-2 border-dark-subtle" id="first_name" name="first_name" placeholder="">
                    </div>
                    <div class="col-md-6" >
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control border-2 border-dark-subtle" id="last_name" name="last_name" placeholder="">
                    </div>
                    <div class="col-md-4" >
                        <label for="program" class="form-label">Program</label>
                        <input type="text" class="form-control border-2 border-dark-subtle"  id="program"  name="program"placeholder="">
                    </div>
                    <div class="col-md-4" >
                        <label for="year_level" class="form-label">Year Level</label>
                        <input type="num" class="form-control border-2 border-dark-subtle" id="year_level" name="year_level" placeholder="">
                    </div>
                    <div class="col-md-4" >
                        <label for="block" class="form-label">Block</label>
                        <input type="text" class="form-control border-2 border-dark-subtle"  id="block"  name="block"placeholder="">
                    </div>
                    <div class="col-md-12" >
                        <label for="email" class="form-label">Student Email</label>
                        <input type="text" class="form-control border-2 border-dark-subtle"  id="email"  name="email" placeholder="">
                    </div>
                    <div class="col-md-12" >
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control border-2 border-dark-subtle"  id="password"  name="password"placeholder="">
                    </div>
                    <div class="col-12 d-md-flex justify-content-md-end" >
                        
                    
                    <button type="submit" class="btn">
                            Get Started
                    </button>
                
                       
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    

</body>
@endsection