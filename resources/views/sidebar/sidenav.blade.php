<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="{{ asset('js/sidenav.js') }}"></script>


<header class="header" id="header">
  <div class="header_toggle" id="header-toggle"> <i class="bi bi-list"></i> </div>
  <div class="header_img col-auto col-md-2"><i class="bi bi-calendar2-week-fill h3"></i> <h6 id="datetime"></h6> </div>
</header>
<div class="l-navbar" id="nav-bar">
  <nav class="nav">
      <div> 
        <a href="{{route('landingpage')}}" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name"><img class="mx-auto d-block" width="150" height="150" src="{{ asset('assets/strlogo.png') }}" alt="user profile"></span> </a>
        <a href="#" class="nav_logo">  <span class="nav_logo-name">Barangay {{auth()->user()->barangay}}</span> </a>
          <div class="nav_list"> 
            <a href="{{route('landingpage')}}" class="nav_link"> <i class="bi bi-clipboard-data nav_icon"></i> <span class="nav_name">Dashboard</span> </a> 
            <a href="{{ route('latest') }}" class="nav_link"> <i class="bi bi-exclamation-circle nav_icon"></i> <span class="nav_name">Incident Reports</span> </a>
            <a href="{{ route('residents') }}" class="nav_link"> <i class="bi bi-person-fill-gear nav_icon"></i> <span class="nav_name">Manage Accounts</span> </a>
            <a href="{{ route('responders') }}" class="nav_link"> <i class="bi bi-person-fill-gear nav_icon"></i> <span class="nav_name">Responders Contact#</span> </a>

            <a class="dropdown-btn nav_link">
              <i class="bi bi-caret-down-fill"></i>
              <span class="nav_name">Emergency Status</span>
            </a>
            <div class="dropdown-container nav_link">
              <a class="nav_link" onclick="window.location='{{route('pendingpage')}}'"><i class="bi bi-exclamation-triangle"></i><span class="nav_name">Pending</span></a>
              <a class="nav_link" onclick="window.location='{{route('responding')}}'"><i class="bi bi-arrow-repeat"></i><span class="nav_name">Responding</span></a>
              <a class="nav_link" onclick="window.location='{{route('completedpage')}}'"><i class="bi bi-check-circle"></i><span class="nav_name">Completed</span></a>
              <a class="nav_link" onclick="window.location='{{route('unavailable')}}'"><i class="bi bi-send-exclamation"></i><span class="nav_name">Queue</span></a>
              <a class="nav_link mb-0" onclick="window.location='{{route('cancelled')}}'"><i class="bi bi-x-circle-fill"></i><span class="nav_name">Cancelled</span></a>
            </div>
            <a class="dropdown-btn nav_link"> <i class="bi bi-caret-down-fill"></i> <span class="nav_name">Incident Status</span> </a> 
            <div class="dropdown-container nav_link">
              <a class="nav_link" onclick="window.location='{{route('respondedreports')}}'"><i class="bi bi-arrow-repeat"></i><span class="nav_name">Responding</span></a>
              <a class="nav_link" onclick="window.location='{{route('completedreports')}}'"><i class="bi bi-check-circle"></i><span class="nav_name">Completed</span></a>
              <a class="nav_link" onclick="window.location='{{route('unavailablereports')}}'"><i class="bi bi-send-exclamation"></i><span class="nav_name">Queue</span></a>
              <a class="nav_link mb-0" onclick="window.location='{{route('cancelledreports')}}'"><i class="bi bi-x-circle-fill"></i><span class="nav_name">Cancelled</span></a>

            </div>
 
          </div>
      </div> 
      <a href="/logout" class="nav_link"> <i class="bi bi-box-arrow-left"></i> <span class="nav_name">SignOut</span> </a>
  </nav>
</div>

