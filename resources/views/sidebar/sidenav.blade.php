<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="{{ asset('js/sidenav.js') }}"></script>
{{-- <div class="d-flex " style="background-color: #a8895e; min-height: 100vh; ">
<nav id="sidenav" class="d-flex flex-column flex-shrink-0 p-3 sticky-top" style="width: 320px;  color: #fff; ">
    <img class="mx-auto d-block" width="120" height="150" src="{{ asset('assets/logo.png') }}" alt="user profile">
      <span class="fs-3 text-center">O-TAP</span>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto gap-2 " >

      <li>
        <a href="{{route('landingpage')}}" class="nav-link link-dark " style="color: #fff">
            <i class="bi bi-clipboard-data h5"><span style="font-style: normal"> Dashboard</span></i>
        </a>
      </li>
      <hr>

      <li>
        <a href="{{ route('latest') }}" class="nav-link link-dark" style="color: #fff">
          <i class="bi bi-exclamation-circle h5"><span style="font-style: normal"> Incident Reports </span></i>
        </a>
      </li>
      <hr>

      <li>
        <a href="{{ route('forwarded') }}" class="nav-link link-dark" style="color: #fff">
          <i class="bi bi-send-exclamation h5"><span style="font-style: normal"> Forwarded Emergency</span></i>
          
        </a>
      </li>
      
    <hr>
       
    </ul>
      <div class="nav-item my-2 d-flex align-items-end position-fixed" style="bottom: 0;">
                <a class="nav-link " href="/logout" ><i class="bi bi-box-arrow-right h4"></i><span class="d-none d-md-inline h4"> Logout</span></a>
        </div>
    
</nav>
</div> --}}

<header class="header" id="header">
  <div class="header_toggle" id="header-toggle"> <i class="bi bi-list"></i> </div>
  
</header>
<div class="l-navbar" id="nav-bar">
  <nav class="nav">
      <div> 
        <a href="{{route('landingpage')}}" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name"><img class="mx-auto d-block" width="150" height="150" src="{{ asset('assets/otaplogo.png') }}" alt="user profile"></span> </a>
        <a href="#" class="nav_logo">  <span class="nav_logo-name">Barangay {{auth()->user()->barangay}}</span> </a>
          <div class="nav_list"> 
            <a href="{{route('landingpage')}}" class="nav_link"> <i class="bi bi-clipboard-data nav_icon"></i> <span class="nav_name">Dashboard</span> </a> 
            <a href="{{ route('latest') }}" class="nav_link"> <i class="bi bi-exclamation-circle nav_icon"></i> <span class="nav_name">Incident Reports</span> </a> 
            <a href="{{ route('forwarded') }}" class="nav_link"> <i class="bi bi-send-exclamation nav_icon"></i> <span class="nav_name">Forwarded Emergency</span> </a> 
          </div>
      </div> 
      <a href="/logout" class="nav_link"> <i class="bi bi-box-arrow-left"></i> <span class="nav_name">SignOut</span> </a>
  </nav>
</div>

