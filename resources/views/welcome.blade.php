@extends('layouts.app')

@section('content')

<body class="container-fluid g-0"style="background-color: #d2ac76">
        <div class="row g-0">
            <div class="col" id="left">
                <!-- get the landing-page.png using image asset -->
                <h1 class="ms-5 my-5 ps-2 fw-bold " style=" color: white; font-size: 45px;">O-TAP: One Tap Assistance for Barangay</h1>
                <center>
                <form action="{{route('login.perform')}}" method="POST">
                @csrf
                    <div class="form-floating mb-3 align-items-center" style="width:70%">
                        <input type="email" class="form-control" value="{{old("email")}}" id="floatingInput" name="email" placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                @if ($errors->has('email'))
                    <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                @endif
                    <div class="form-floating align-items-center" style="width:70%">
                        <input type="password" class="form-control" value="{{old("password")}}"  id="floatingPassword" name="password" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                @if ($errors->has('password'))
                    <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                @endif
                    <div class="row" style="width: 70%; margin: 2%">
                        <div class="col-6">
                            <div class="form-check">
                                <input style="margin-left: -21%" class="form-check-input" type="checkbox" value="" id="defaultCheck1" >
                                <label style="margin-left: -20%" class="form-check-label" for="defaultCheck1">Remember me</label>
                            </div>
                        </div>
                    
                    </div> 
                    <button class="text-dark bg-white mt-4" type="submit" style=" width: 70%; border: none; padding: 12px 24px; text-align: center; font-size: 16px; cursor: pointer; border-radius: 8px;">Login</button>
                </form>
                </center>
            </div>
            <div class="col" id="right">
                
                <img id= "shape" class="img-fluid float-end" src="{{ asset('assets/shape.png') }}" alt="geo">

            </div>
        </div>
</body>

@endsection