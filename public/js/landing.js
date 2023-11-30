
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
          <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" data-bs-toggle="modal" data-incident-id="${value.id}" data-bs-target="#pending${value.id}" style="width: 100%; margin: 10px; border: none">
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

  window.Echo.channel('incident-channel')
  .listen('IncidentCreated', (event) => {
      console.log('New incident created:', event.incident);
      $('#latestIncidentCont').empty();
      getLatest();
  });

 