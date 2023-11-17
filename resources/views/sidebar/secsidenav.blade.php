<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<nav id="sidenav" class="d-flex flex-column flex-shrink-0 p-3 " style="width: 20vh; height: 100vh; background-color: #a8895e; color: #fff">
    <span class="fs-4"><img class="bi me-2" width="45" height="55" src="{{ asset('assets/logo.png') }}" alt="user profile">
      O-TAP</span>
    <h6>One-Tap Assistance Platform</h6>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto gap-2" >

      <li>
        <a href="{{route('secadminpage')}}" class="nav-link link-dark" style="color: #fff">
            <i class="bi bi-clipboard-data"></i>
            Dashboard
        </a>
      </li>

      <li>
        <a href="{{ route('seclatest') }}" class="nav-link link-dark" style="color: #fff">
          <i class="bi bi-exclamation-circle"></i>
          Latest Incidents
        </a>
      </li>

      <li>
        <a href="{{ route('secforwarded') }}" class="nav-link link-dark" style="color: #fff">
          <i class="bi bi-send-exclamation"></i>
          Forwarded Emergency
        </a>
      </li>
      
    <hr>
       
    </ul>
      <li class="nav-item my-2 d-flex align-items-end">
                <a class="nav-link " href="/logout" ><i class="bi bi-box-arrow-right"></i><span class="d-none d-md-inline">Logout</span></a>
        </li>
    
</nav>

