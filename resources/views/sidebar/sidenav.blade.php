
{{-- <nav  id="sidenav" class="p-4 vh-100 col-md-2 col-lg-2"> --}}
        {{-- <div class="mb-5">
            <img class="img-fluid mx-auto d-block" src="{{ asset('assets/logo.png') }}" alt="user profile">
            <p class="fs-5 mb-0 text-center"></p>
            <p class="fs-6 text-center"> </p>
        </div>
        <div class="mt-5">
        <ul class="navbar-nav flex-column ">
            <li class="nav-item my-2">
                <a class="nav-link active" aria-current="true" href="{{route('landingpage')}}" >Dashboard</a>
            </li>
            <li class="nav-item my-2">
                <a class="nav-link pl-0" href="{{ route('latest') }}"   ><i class="bi bi-file-earmark-plus"></i><span class="d-none d-md-inline">Latest Incidents</span></a>
            </li>
            <li class="nav-item my-2">
                <a class="nav-link pl-0" href="{{ route('forwarded') }}"   ><i class="bi bi-file-plus-fill"></i><span class="d-none d-md-inline">Forwarded Emergency</span></a>
            </li>
        
            <li class="nav-item my-2">
                <a class="nav-link " href="/logout" ><i class="bi bi-box-arrow-right"></i><span class="d-none d-md-inline">Logout</span></a>
            </li>
        </ul>
        </div> --}}

{{-- <div class="maincontainer"> --}}
    {{-- <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
      <span class="fs-4">Sidebar</span>
    </a> --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<nav id="sidenav" class="d-flex flex-column flex-shrink-0 p-3 " style="width: 220px; height: 100vh; background-color: #a8895e; color: #fff">
    <span class="fs-4"><img class="bi me-2" width="45" height="55" src="{{ asset('assets/logo.png') }}" alt="user profile">
      O-TAP</span>
    <h6>One-Tap Assistance Platform</h6>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto gap-2" >

      <li>
        <a href="{{route('landingpage')}}" class="nav-link link-dark" style="color: #fff">
            <i class="bi bi-clipboard-data"></i>
            Dashboard
        </a>
      </li>

      <li>
        <a href="{{ route('latest') }}" class="nav-link link-dark" style="color: #fff">
          <i class="bi bi-exclamation-circle"></i>
          Latest Incidents
        </a>
      </li>

      <li>
        <a href="{{ route('forwarded') }}" class="nav-link link-dark" style="color: #fff">
          <i class="bi bi-send-exclamation"></i>
          Forwarded Emergency
        </a>
      </li>
      
    <hr>
       
    </ul>
      <li class="nav-item my-2 d-flex align-items-end">
                <a class="nav-link " href="/logout" ><i class="bi bi-box-arrow-right"></i><span class="d-none d-md-inline">Logout</span></a>
        </li>
    {{-- <div class="dropdown">
      <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong>mdo</strong>
      </a>
      <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
        <li><a class="dropdown-item" href="#">New project...</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Sign out</a></li>
      </ul>
    </div> --}}
</nav>
{{-- </div> --}}
{{-- </nav> --}}