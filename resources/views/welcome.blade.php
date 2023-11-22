

@extends('layouts.app')

@section('pageTitle')
Login
@endsection

@section('css')
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('css/user_loginReg.css') }}" >
<link rel="stylesheet" type="text/css" href="{{ asset('css/loginbg.css') }}" >
@endsection

@section('content')
        <section class="vh-100">
            
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-6  col-xl-10">
                        <div class="card card_whole_container" style="border-radius: 1rem;">
                            <div class="row g-0 ">
                                <div class="col-md-6 col-lg-5 d-none d-md-block loginReg_icon_container" style="border-radius: 1rem 0 0 1rem;">
                                    <img class="w-200 img-fluid" style="border-radius: 1rem 0 0 1rem;" src="{{url('/assets/loginpic.jpg')}}" />
                                </div>
                                <div class="col-md-6 col-lg-7 ">
                                    
                                    <div class="card-body p-4 p-lg-5 text-black wholeCard">
                                            <div class="d-flex align-items-center justify-content-center mb-5 pb-1">
                                                <img class="img-fluid" src="{{url('/assets/otaplogo.png')}}" style="width: 12%;"/>
                                                <h5 class="loginAppName">One-Tap Assistance Platform</h5>
                                            </div>
    
                                        <form method="post" action="{{ route('login.perform') }}" class="loginForm">
                                            @csrf
    
                                           
                                          
                        
                                            <div class="form-group form-floating align-items-center mt-3 d-flex form_icon_input border rounded-2 py-1 px-3">
                                                <i class="bi bi-person-fill h3 mt-2 loginIcon"></i>
                                                <input type="email" class="form-control shadow-none border-0 normal_text"  value="{{ old("email")}}" name="email" placeholder="Email" required="required" autofocus>
                                                <label for="floatingInput" class="floatingInput">Email address</label>
                                            </div>
    
                                            @if ($errors->has('email'))
                                                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                                @endif
    
                                            <div class="form-group form-floating align-items-center mt-3 d-flex form_icon_input border rounded-2 py-1 px-3">
                                                <i class="bi bi-lock-fill h3 mt-2 loginIcon"></i>
                                                <input type="password" class="form-control shadow-none border-0 normal_text" value="{{ old("password")}}" name="password" placeholder="Password" placeholder="Password" required="required">
                                                <label for="floatingInput" class="floatingInput">Password</label>
                                            </div>
    
                                            @if ($errors->has('password'))
                                            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                            @endif
    
    
                                            <div class="mt-3 mb-4 loginBtn">
                                                <button class="col-12 rounded-2 login_reg_button" type="submit"> LOGIN </button>
                                            </div>
    
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
                <div class='air air1'></div>
                <div class='air air2'></div>
                <div class='air air3'></div>
                <div class='air air4'></div>
             
        </section>

       

@endsection
