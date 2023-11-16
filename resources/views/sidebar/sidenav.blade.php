<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<div class="d-flex " style="background-color: #a8895e; min-height: 100vh; ">
<nav id="sidenav" class="d-flex flex-column flex-shrink-0 p-3 sticky-top" style="width: 220px;  color: #fff; ">
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
</div>