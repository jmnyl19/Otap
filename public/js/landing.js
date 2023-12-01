
$(document).ready(function () {
  getLatest();
});

function forward(incidentID) {
    var selectedBarangay = document.getElementById('forwardDropdown').value;
    var incidentStatus = document.getElementById('incidentStatus').value;
    Swal.fire({
      title: 'Confirmation',
      text: 'Are you sure you want to forward this emergency?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Forward',
      background: '#fff',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#4BB1F7',
      cancelButtonColor: '#c2c2c2',
      
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: '/forward/' + incidentID,
          type: 'POST',
          data: {
            incident_id: incidentID,
            status: incidentStatus,
            barangay: selectedBarangay
          },
          success: function(response) {
            Swal.fire({
              title: 'Success!',
              text: 'Emergency has been forwarded successfully.',
              icon: 'success',
              confirmButtonText: 'OK',
              confirmButtonColor: '#4BB1F7',
              background: '#fff',
            }).then((result) => {
              location.reload();
            });
          },
          error: function(xhr, status, error) {
            console.error(error); // Handle the error response as per your requirements
            Swal.fire({
              title: 'Error!',
              text: 'Failed to forward the emergency. Please try again.',
              icon: 'error',
              confirmButtonText: 'OK',
              confirmButtonColor: '#4BB1F7',
              color: '#fff',
            });
          }
        });
      }
    });
  }


  function respond(incidentID) {

    Swal.fire({
      title: 'Confirmation',
      text: 'Are you sure you want to respond to this emergency?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Respond',
      background: '#fff',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#4BB1F7',
      cancelButtonColor: '#c2c2c2',
      
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: '/respond/' + incidentID,
          type: 'POST',
          data: {
            incident_id: incidentID,
          },
          success: function(response) {
            Swal.fire({
              title: 'Success!',
              text: 'Responded to this emergency successfully.',
              icon: 'success',
              confirmButtonText: 'OK',
              confirmButtonColor: '#4BB1F7',
              background: '#fff',
            }).then((result) => {
              location.reload();
            });
          },
          error: function(xhr, status, error) {
            console.error(error); // Handle the error response as per your requirements
            Swal.fire({
              title: 'Error!',
              text: 'Failed to respond to this emergency. Please try again.',
              icon: 'error',
              confirmButtonText: 'OK',
              confirmButtonColor: '#4BB1F7',
              color: '#fff',
            });
          }
        });
      }
    });
  }

  function getLatest() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getlatestincidents',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        $.each(response.incidents, function(index, value) {
          var incidentHtml = `
          <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
              <div class="card-body">
                  <div class="row align-items-center text-start">
                      <div class="col-auto">
                          <h1 style="color: red">|</h1>
                      </div>
                      <div class="col">
                          <h6 style="color: #000">${value.type}</h6>
                      </div>
                  </div>
              </div>
          </div>
      `;

      // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
      $('#latestIncidentCont').append(incidentHtml);
        });

      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
  }

  function pendingModal(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/currentincident/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          
            console.log(response);
            $('#pendingModalBody').empty();
            $('#pendingModal').modal('show');
            var incidentHtml = `
                <!-- Google Map Container -->
                <div id="map${response.history[0].id}" style="height: 350px;">
                </div>
              
                <!-- Rest of the modal content -->
                <hr class="style-one">
                <div class="square-container mt-2 p-20">
                    <div class="shadow p-3 mb-1 rounded modalInfo">
                        <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${response.history[0].created_at}</h5>
                        <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history[0].type}</h5>
                        <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history[0].user.first_name} ${response.history[0].user.last_name}</h5>
                        <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: ${response.history[0].user.age}</h5>
                        <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: ${response.history[0].user.barangay}</h5>
                        <h5 id="address{{$incident_modal->id}}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                    </div>
                </div>
            `;
            $('#pendingModalBody').append(incidentHtml);

            $('#pendingModalFooter').empty();
            var pendingFooter = `
                <form action="" method="POST">
                    <button class="respondBtn" type="button" onclick="respond(${response.history[0].id})">
                        <div class="svg-wrapper-1">
                          <div class="svg-wrapper">
                            <svg viewBox="0 0 24 24"
                            width="24"
                            height="24" 
                            version="1.1" 
                            xmlns="http://www.w3.org/2000/svg" 
                            xmlns:xlink="http://www.w3.org/1999/xlink" 
                            fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <title>arrow_repeat [#238]</title> 
                                    <desc>Created with Sketch.</desc> <defs> </defs> 
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> 
                                        <g id="Dribbble-Light-Preview" transform="translate(-222.000000, -7080.000000)" fill="#ffffff"> 
                                            <g id="icons" transform="translate(56.000000, 160.000000)"> 
                                                <path d="M174.034934,6926.99996 C173.480532,6926.99996 173.030583,6927.44796 173.030583,6927.99996 L173.030583,6930.99994 L178.052339,6930.99994 C178.606741,6930.99994 179.05669,6930.49994 179.05669,6929.94795 L179.05669,6929.92095 C179.05669,6929.36895 178.606741,6928.99995 178.052339,6928.99995 L175.039285,6928.99995 L175.039285,6927.99996 C175.039285,6927.44796 174.589336,6926.99996 174.034934,6926.99996 M180.988058,6929.99995 C180.487891,6929.99995 180.071085,6930.36694 179.999776,6930.85894 C179.520701,6934.16792 176.319833,6936.61391 172.736308,6935.86392 C170.462456,6935.38792 168.623489,6933.55693 168.145418,6931.29294 C167.32888,6927.42296 170.287699,6923.99998 174.034934,6923.99998 L174.034934,6925.99997 L179.05669,6922.99998 L174.034934,6920 L174.034934,6921.99999 C169.070425,6921.99999 165.157472,6926.48297 166.156802,6931.60494 C166.765439,6934.72392 169.290378,6937.23791 172.42295,6937.8439 C177.169514,6938.7619 181.369712,6935.51592 181.990401,6931.12594 C182.074766,6930.52994 181.591673,6929.99995 180.988058,6929.99995" id="arrow_repeat-[#238]"> 

                                                </path> 
                                            </g> 
                                        </g> 
                                    </g> 
                                </g>
                            </svg>
                          </div>
                        </div><span>Respond</span>
                    </button>
                </form>
                <form action="" method="POST">
                    <button class="forwardBtn" type="button" onclick="forward(${response.history[0].id})">
                        <div class="svg-wrapper-1">
                          <div class="svg-wrapper">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 24 24"
                              width="24"
                              height="24"
                            >
                              <path fill="none" d="M0 0h24v24H0z"></path>
                              <path
                                fill="currentColor"
                                d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"
                              ></path>
                            </svg>
                          </div>
                        </div><span>Forward</span>
                      </button>     
                </form>
            `;

            $('#pendingModalFooter').append(pendingFooter);
            initMap('map' + response.history[0].id, response.history[0].latitude, response.history[0].longitude, response.history[0].id);
        },
        error: function (error) {
            console.log('Error fetching latest incidents:', error);
        }
    });
}





var maps = [];

    // function initMaps() {
    //     @foreach ($pendingIncidents as $incident_modal)
    //         initMap('map{{$incident_modal->id}}', {{$incident_modal->latitude}}, {{$incident_modal->longitude}}, '{{$incident_modal->id}}');
    //     @endforeach
    //     @foreach ($forwardedIncidents as $incident1)
    //         initMap('map{{$incident1->incident->id}}', {{$incident1->incident->latitude}}, {{$incident1->incident->longitude}}, '{{$incident1->id}}');
    //     @endforeach
    // }

    function initMap(mapId, latitude, longitude, incidentId) {
        var incidentLocation = { lat: latitude, lng: longitude };
        var map = new google.maps.Map(document.getElementById(mapId), {
            zoom: 18,
            center: incidentLocation
        });
        var marker = new google.maps.Marker({
            position: incidentLocation,
            map: map
        });

        // Store the map instance in the array
        maps.push({ id: mapId, map: map });

        // Reverse geocoding
        var geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(latitude, longitude);

        geocoder.geocode({ 'latLng': latlng }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    // Display the formatted address in an info window or console.log
                    var addressElement = document.getElementById('address' + incidentId);
                    addressElement.innerHTML = '<i class="bi bi-house-down-fill modalIcon"></i>Specific Location:: ' + results[1].formatted_address;
                } else {
                    console.log('No results found');
                }
            } else {
                console.log('Geocoder failed due to: ' + status);
            }
        });
    }


  window.Echo.channel('incident-channel')
  .listen('IncidentCreated', (event) => {
      console.log('New incident created:', event.incident);
      $('#latestIncidentCont').empty();
      getLatest();
  });

  $('#latestIncidentCont').on('click', '.btn-primary', function() {
    var incidentId = $(this).data('incident-id');
    $('#exampleModal' + incidentId).modal('show');
});