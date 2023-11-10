
<nav  id="sidenav" class="p-4 vh-100 col-md-2 col-lg-2">
        <div class="mb-5">
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
        </div>
</nav>