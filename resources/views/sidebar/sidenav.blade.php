<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


  <div class="l-navbar" id="sidenav">
    <div class="header" id="headerId">
      <div class="header_toggle " id="toggleId"> <i class="bi bi-list"></i> </div>
    </div>
    <nav class="nav" id="navId">
      <div>
        <a href="#" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">BBBootstrap</span> </a>
        <div class="nav_list">
          <a href="{{route('landingpage')}}" class="nav_link active"> <i class="bi bi-clipboard-data"></i> <span class="nav_name">Dashboard</span> </a>
          <a href="{{ route('latest') }}" class="nav_link"> <i class="bi bi-exclamation-circle"></i> <span class="nav_name">Users</span> </a>
          <a href="{{ route('forwarded') }}" class="nav_link"> <i class="bi bi-send-exclamation"></i> <span class="nav_name">Messages</span> </a>
        </div>
      </div> <a href="#" class="nav_link"> <i class="bi bi-box-arrow-right"></i> <span class="nav_name">SignOut</span> </a>
    </nav>
  </div>

  
<script>
   document.addEventListener("DOMContentLoaded", function (event) {
    const toggle = document.getElementById("toggleId"),
      nav = document.getElementById("navId"),
      bodypd = document.getElementById("bodyId"),
      headerpd = document.getElementById("headerId");

    const showNavbar = () => {
      // Validate that all variables exist
      if (toggle && nav && bodypd && headerpd) {
        // show navbar
        nav.classList.toggle('show');   
        // change icon
        toggle.classList.toggle('bx-x');
        // add padding to body
        bodypd.classList.toggle('body-pd');
        // add padding to header
        headerpd.classList.toggle('body-pd');
      }
    };

    const linkColor = document.querySelectorAll('.nav_link');

    function colorLink() {
  linkColor.forEach((l) => l.classList.remove('active'));
  this.classList.add('active');
} 

    linkColor.forEach(l => l.addEventListener('click', colorLink));

    // Add event listener for the toggle button
    toggle.addEventListener('click', showNavbar);
  });
</script>

<style>
  /* Your styles here */
</style>