
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
        console.log(response);
        $.each(response.incidents, function(index, value) {
          var incidentHtml = '';
          if (value.type == 'Requesting for Ambulance') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: red">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
          `;
          } else if (value.type == 'Requesting for a Fire Truck') {
            incidentHtml += `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                <div class="card-body">
                    <div class="row align-items-center text-start">
                        <div class="col-auto">
                            <h1 style="color: rgb(255, 132, 0)">|</h1>
                        </div>
                        <div class="col">
                            <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span> ${value.type}</h6>
                        </div>
                    </div>
                </div>
            </div>
          `;
        } else {
          incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(0, 157, 255) ">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          
        }

      // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
      $('#latestIncidentCont').append(incidentHtml);
        });

        $.each(response.allincidents, function(index, value) {
          var incidentHtml = '';
          if (value.type == 'Requesting for Ambulance') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: red">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
          `;
          } else if (value.type == 'Requesting for a Fire Truck') {
            incidentHtml += `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                <div class="card-body">
                    <div class="row align-items-center text-start">
                        <div class="col-auto">
                            <h1 style="color: rgb(255, 132, 0)">|</h1>
                        </div>
                        <div class="col">
                            <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span> ${value.type}</h6>
                        </div>
                    </div>
                </div>
            </div>
          `;
        } else {
          incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(0, 157, 255) ">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          
        }

      // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
      $('#allIncidentCont').append(incidentHtml);
        });

        $.each(response.resincidents, function(index, value) {
          var incidentHtml = '';
          if (value.type == 'Requesting for Ambulance') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="respondingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: red">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
          `;
          } else if (value.type == 'Requesting for a Fire Truck') {
            incidentHtml += `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="respondingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                <div class="card-body">
                    <div class="row align-items-center text-start">
                        <div class="col-auto">
                            <h1 style="color: rgb(255, 132, 0)">|</h1>
                        </div>
                        <div class="col">
                            <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span> ${value.type}</h6>
                        </div>
                    </div>
                </div>
            </div>
          `;
        } else {
          incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="respondingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(0, 157, 255) ">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          
        }

      // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
      $('#allPendingCont').append(incidentHtml);
        });
      
        $.each(response.recincidents, function(index, value) {
          var incidentHtml = '';
  
          // Add your custom condition here
          if (value.incident.type == 'Requesting for Ambulance') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: red">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:  ${value.incident.type} </h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else if (value.incident.type == 'Requesting for a Fire Truck') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(255, 132, 0)">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:  ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(0, 157, 255) ">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:   ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          }   
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#latestForIncidentCont').append(incidentHtml);
          });

        $.each(response.allrecincidents, function(index, value) {
          var incidentHtml = '';
  
          // Add your custom condition here
          if (value.incident.type == 'Requesting for Ambulance') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: red">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:  ${value.incident.type} </h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else if (value.incident.type == 'Requesting for a Fire Truck') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(255, 132, 0)">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:  ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(0, 157, 255) ">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:   ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          }   
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#allForIncidentCont').append(incidentHtml);
          });
        
        $.each(response.resrecincidents, function(index, value) {
          var incidentHtml = '';
  
          // Add your custom condition here
          if (value.incident.type == 'Requesting for Ambulance') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="respondingModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: red">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:  ${value.incident.type} </h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else if (value.incident.type == 'Requesting for a Fire Truck') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="respondingModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(255, 132, 0)">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:  ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="respondingModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(0, 157, 255) ">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:   ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          }   
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#allForwardedPendingCont').append(incidentHtml);
          });
      
        $.each(response.forincidents, function(index, value) {
          var incidentHtml = '';
          if (value.type == 'Requesting for Ambulance') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="forwardedModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: red">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
          `;
          } else if (value.type == 'Requesting for a Fire Truck') {
            incidentHtml += `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="forwardedModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                <div class="card-body">
                    <div class="row align-items-center text-start">
                        <div class="col-auto">
                            <h1 style="color: rgb(255, 132, 0)">|</h1>
                        </div>
                        <div class="col">
                            <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span> ${value.type}</h6>
                        </div>
                    </div>
                </div>
            </div>
          `;
        } else {
          incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="forwardedModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(0, 157, 255) ">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          
        }

      // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
      $('#ForwardedCont').append(incidentHtml);
        });

        $.each(response.comincidents, function(index, value) {
          var incidentHtml = '';
          if (value.type == 'Requesting for Ambulance') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="completedModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: red">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
          `;
          } else if (value.type == 'Requesting for a Fire Truck') {
            incidentHtml += `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="completedModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                <div class="card-body">
                    <div class="row align-items-center text-start">
                        <div class="col-auto">
                            <h1 style="color: rgb(255, 132, 0)">|</h1>
                        </div>
                        <div class="col">
                            <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span> ${value.type}</h6>
                        </div>
                    </div>
                </div>
            </div>
          `;
        } else {
          incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="completedModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(0, 157, 255) ">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          
        }

      // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
      $('#CompletedCont').append(incidentHtml);
        });
        $.each(response.forcomincidents, function(index, value) {
          var incidentHtml = '';
  
          // Add your custom condition here
          if (value.incident.type == 'Requesting for Ambulance') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="completedModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: red">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:  ${value.incident.type} </h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else if (value.incident.type == 'Requesting for a Fire Truck') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="completedModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(255, 132, 0)">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:  ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="completedModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(0, 157, 255) ">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:   ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          }   
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#completedForwardedCont').append(incidentHtml);
          });
        $.each(response.receIncidents, function(index, value) {
          var incidentHtml = '';
  
          // Add your custom condition here
          if (value.incident.type == 'Requesting for Ambulance') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="receivedModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: red">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:  ${value.incident.type} </h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else if (value.incident.type == 'Requesting for a Fire Truck') {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="receivedModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(255, 132, 0)">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:  ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else {
            incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="receivedModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(0, 157, 255) ">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${ value.barangay}:   ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          }   
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#allReceivedCont').append(incidentHtml);
          });
        // incident reporting 
          $.each(response.reports, function(index, value) {
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="reportModal(${value.id})" style="width: 100%; margin: 10px; border: none">
            <div class="card-body">
                <div class="row align-items-center text-start">
                    <div class="col-auto">
                        <h1 style="color: red">|</h1>
                    </div>
                    <div class="col">
                        <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span></h6>
                    </div>
                </div>
            </div>
        </div>
        `;
          
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#getReportsCont').append(incidentHtml);
          });
          $.each(response.forreports, function(index, value) {
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="reportModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
            <div class="card-body">
                <div class="row align-items-center text-start">
                    <div class="col-auto">
                        <h1 style="color: red">|</h1>
                    </div>
                    <div class="col">
                        <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span></h6>
                    </div>
                </div>
            </div>
        </div>
        `;
          
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#getReceivedReportsCont').append(incidentHtml);
          });
          $.each(response.resreports, function(index, value) {
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="respondingreportModal(${value.id})" style="width: 100%; margin: 10px; border: none">
            <div class="card-body">
                <div class="row align-items-center text-start">
                    <div class="col-auto">
                        <h1 style="color: red">|</h1>
                    </div>
                    <div class="col">
                        <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span></h6>
                    </div>
                </div>
            </div>
        </div>
        `;
          
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#getRespondingReportCont').append(incidentHtml);
          });
          $.each(response.resforreports, function(index, value) {
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="respondingreportModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
            <div class="card-body">
                <div class="row align-items-center text-start">
                    <div class="col-auto">
                        <h1 style="color: red">|</h1>
                    </div>
                    <div class="col">
                        <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span></h6>
                    </div>
                </div>
            </div>
        </div>
        `;
          
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#ResReportCont').append(incidentHtml);
          });

          $.each(response.foreport, function(index, value) {
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="reportsForModal(${value.id})" style="width: 100%; margin: 10px; border: none">
            <div class="card-body">
                <div class="row align-items-center text-start">
                    <div class="col-auto">
                        <h1 style="color: red">|</h1>
                    </div>
                    <div class="col">
                        <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span></h6>
                    </div>
                </div>
            </div>
        </div>
        `;
          
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#reportForwarded').append(incidentHtml);
          });
          $.each(response.reforwarded, function(index, value) {
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="reportsForModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
            <div class="card-body">
                <div class="row align-items-center text-start">
                    <div class="col-auto">
                        <h1 style="color: red">|</h1>
                    </div>
                    <div class="col">
                        <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span></h6>
                    </div>
                </div>
            </div>
        </div>
        `;
          
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#reportForwarded1').append(incidentHtml);
          });

          $.each(response.compreport, function(index, value) {
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="comReportsModal(${value.id})" style="width: 100%; margin: 10px; border: none">
            <div class="card-body">
                <div class="row align-items-center text-start">
                    <div class="col-auto">
                        <h1 style="color: red">|</h1>
                    </div>
                    <div class="col">
                        <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span></h6>
                    </div>
                </div>
            </div>
        </div>
        `;
          
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#completedReports').append(incidentHtml);
          });
          
          $.each(response.compforreport, function(index, value) {
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="comReportsModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
            <div class="card-body">
                <div class="row align-items-center text-start">
                    <div class="col-auto">
                        <h1 style="color: red">|</h1>
                    </div>
                    <div class="col">
                        <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span></h6>
                    </div>
                </div>
            </div>
        </div>
        `;
          
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#completedReports1').append(incidentHtml);
          });
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
  }
  
  // function getallLatest() {
  //   $.ajaxSetup({
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     }
  //   });
  //   $.ajax({
  //     url: '/getallincidents',
  //     type: 'GET',
  //     dataType: 'json',
  //     success: function (response) {
  //       console.log(response);
  //       $.each(response.incidents, function(index, value) {
  //         var incidentHtml = '';
  //         if (value.type == 'Requesting for Ambulance') {
  //           incidentHtml += `
  //             <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
  //                 <div class="card-body">
  //                     <div class="row align-items-center text-start">
  //                         <div class="col-auto">
  //                             <h1 style="color: red">|</h1>
  //                         </div>
  //                         <div class="col">
  //                             <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
  //                         </div>
  //                     </div>
  //                 </div>
  //             </div>
  //         `;
  //         } else if (value.type == 'Requesting for a Fire Truck') {
  //           incidentHtml += `
  //           <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
  //               <div class="card-body">
  //                   <div class="row align-items-center text-start">
  //                       <div class="col-auto">
  //                           <h1 style="color: rgb(255, 132, 0)">|</h1>
  //                       </div>
  //                       <div class="col">
  //                           <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span> ${value.type}</h6>
  //                       </div>
  //                   </div>
  //               </div>
  //           </div>
  //         `;
  //       } else {
  //         incidentHtml += `
  //             <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="pendingModal(${value.id})" style="width: 100%; margin: 10px; border: none">
  //                 <div class="card-body">
  //                     <div class="row align-items-center text-start">
  //                         <div class="col-auto">
  //                             <h1 style="color: rgb(0, 157, 255) ">|</h1>
  //                         </div>
  //                         <div class="col">
  //                             <h6 style="color: #000"><span class="fw-bold">(${value.created_at})</span>${value.type}</h6>
  //                         </div>
  //                     </div>
  //                 </div>
  //             </div>
  //           `;
          
  //       }

  //     // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
  //     $('#getallIncidentCont').append(incidentHtml);
  //       });
      
        
  //     },
  //     error: function (error) {
  //         console.log('Error fetching latest incidents:', error);
  //     }
  // });
  // }

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
                      <h5 id="address${response.history[0].id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
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
function respondingModal(id) {
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
        $('#respondingModalBody').empty();
        $('#respondingModal').modal('show');
        var incidentHtml = `
            <!-- Google Map Container -->
            <div id="map${response.history2[0].id}" style="height: 350px;">
            </div>
          
            <!-- Rest of the modal content -->
            <hr class="style-one">
            <div class="square-container mt-2 p-20">
                <div class="shadow p-3 mb-1 rounded modalInfo">
                    <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${response.history2[0].created_at}</h5>
                    <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history2[0].type}</h5>
                    <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history2[0].user.first_name} ${response.history[0].user.last_name}</h5>
                    <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: ${response.history2[0].user.age}</h5>
                    <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: ${response.history2[0].user.barangay}</h5>
                    <h5 id="address${response.history2[0].id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                </div>
            </div>
        `;
        $('#respondingModalBody').append(incidentHtml);

        $('#respondingModalFooter').empty();
        var pendingFooter = `
            
            <form action="" method="POST">
                <button class="completeBtn" type="button" onclick="completed(${response.history2[0].id})">

                    <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                            <svg  viewBox="0 0 24 24"
                            width="24"
                            height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="#ffffff"></path> </g></svg>
                        </div>
                    </div>
                    <span>Mark as Completed</span>
                    </button>
            </form>
        `;

        $('#respondingModalFooter').append(pendingFooter);
        initMap('map' + response.history2[0].id, response.history2[0].latitude, response.history2[0].longitude, response.history2[0].id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function pendingModal1(id) {
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
        $('#pendingModal1Body').empty();
        $('#pendingModal1').modal('show');
        var incidentHtml = `
            <!-- Google Map Container -->
            <div id="map${response.history1[0].incident.id}" style="height: 350px;">
            </div>
          
            <!-- Rest of the modal content -->
            <hr class="style-one">
            <div class="square-container mt-2 p-20">
                <div class="shadow p-3 mb-1 rounded modalInfo">
                    <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${response.history1[0].created_at}</h5>
                    <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history1[0].incident.type}</h5>
                    <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history1[0].incident.user.first_name} ${response.history1[0].incident.user.last_name}</h5>
                    <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: ${response.history1[0].incident.user.age}</h5>
                    <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: ${response.history1[0].barangay}</h5>
                    <h5 id="address${response.history1[0].incident.id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                </div>
            </div>
        `;
        $('#pendingModal1Body').append(incidentHtml);

        $('#pendingModal1Footer').empty();
        var pendingFooter = `
            <form action="" method="POST">
                <button class="respondBtn" type="button" onclick="responded(${response.history1[0].id})">
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
                <button class="forwardBtn" type="button" onclick="reforward(${response.history1[0].id})">
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

        $('#pendingModal1Footer').append(pendingFooter);
        initMap('map' + response.history1[0].incident.id, response.history1[0].incident.latitude, response.history1[0].incident.longitude, response.history1[0].incident.id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function respondingModal1(id) {
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
        $('#respondingModal1Body').empty();
        $('#respondingModal1').modal('show');
        var incidentHtml = `
            <!-- Google Map Container -->
            <div id="map${response.history3[0].incident.id}" style="height: 350px;">
            </div>
          
            <!-- Rest of the modal content -->
            <hr class="style-one">
            <div class="square-container mt-2 p-20">
                <div class="shadow p-3 mb-1 rounded modalInfo">
                    <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${response.history3[0].created_at}</h5>
                    <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history3[0].incident.type}</h5>
                    <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history3[0].incident.user.first_name} ${response.history3[0].incident.user.last_name}</h5>
                    <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: ${response.history3[0].incident.user.age}</h5>
                    <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: ${response.history3[0].barangay}</h5>
                    <h5 id="address${response.history3[0].incident.id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                </div>
            </div>
        `;
        $('#respondingModal1Body').append(incidentHtml);

        $('#respondingModal1Footer').empty();
        var pendingFooter = `
          <form action="" method="POST">
              <button class="completeBtn" type="button" onclick="forcompleted(${response.history3[0].id})">

                  <div class="svg-wrapper-1">
                      <div class="svg-wrapper">
                          <svg  viewBox="0 0 24 24"
                          width="24"
                          height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="#ffffff"></path> </g></svg>
                      </div>
                  </div>
                  <span>Mark as Completed</span>
                  </button>
          </form>
        `;

        $('#respondingModal1Footer').append(pendingFooter);
        initMap('map' + response.history3[0].incident.id, response.history3[0].incident.latitude, response.history3[0].incident.longitude, response.history3[0].incident.id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function forwardedModal(id) {
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
        $('#forwardedModalBody').empty();
        $('#forwardedModal').modal('show');
        var incidentHtml = `
            <!-- Google Map Container -->
            <div id="map${response.history4[0].id}" style="height: 350px;">
            </div>
          
            <!-- Rest of the modal content -->
            <hr class="style-one">
            <div class="square-container mt-2 p-20">
                <div class="shadow p-3 mb-1 rounded modalInfo">
                    <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${response.history4[0].created_at}</h5>
                    <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history4[0].type}</h5>
                    <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history4[0].user.first_name} ${response.history4[0].user.last_name}</h5>
                    <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: ${response.history4[0].user.age}</h5>
                    <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: ${response.history4[0].user.barangay}</h5>
                    <h5 id="address${response.history4[0].id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                </div>
            </div>
        `;
        $('#forwardedModalBody').append(incidentHtml);

       initMap('map' + response.history4[0].id, response.history4[0].latitude, response.history4[0].longitude, response.history4[0].id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function completedModal(id) {
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
        $('#completedModalBody').empty();
        $('#completedModal').modal('show');
        var incidentHtml = `
            <!-- Google Map Container -->
            <div id="map${response.history5[0].id}" style="height: 350px;">
            </div>
          
            <!-- Rest of the modal content -->
            <hr class="style-one">
            <div class="square-container mt-2 p-20">
                <div class="shadow p-3 mb-1 rounded modalInfo">
                    <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${response.history5[0].created_at}</h5>
                    <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history5[0].type}</h5>
                    <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history5[0].user.first_name} ${response.history5[0].user.last_name}</h5>
                    <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: ${response.history5[0].user.age}</h5>
                    <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: ${response.history5[0].user.barangay}</h5>
                    <h5 id="address${response.history5[0].id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                </div>
            </div>
        `;
        $('#completedModalBody').append(incidentHtml);

       initMap('map' + response.history5[0].id, response.history5[0].latitude, response.history5[0].longitude, response.history5[0].id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function completedModal1(id) {
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
        $('#completedModal1Body').empty();
        $('#completedModal1').modal('show');
        var incidentHtml = `
            <!-- Google Map Container -->
            <div id="map${response.history6[0].incident.id}" style="height: 350px;">
            </div>
          
            <!-- Rest of the modal content -->
            <hr class="style-one">
            <div class="square-container mt-2 p-20">
                <div class="shadow p-3 mb-1 rounded modalInfo">
                    <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${response.history6[0].created_at}</h5>
                    <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history6[0].incident.type}</h5>
                    <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history6[0].incident.user.first_name} ${response.history6[0].incident.user.last_name}</h5>
                    <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: ${response.history6[0].incident.user.age}</h5>
                    <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: ${response.history6[0].barangay}</h5>
                    <h5 id="address${response.history6[0].incident.id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                </div>
            </div>
        `;
        $('#completedModal1Body').append(incidentHtml);

        // $('#respondingModal1Footer').empty();
        // var pendingFooter = `
        //   <form action="" method="POST">
        //       <button class="completeBtn" type="button" onclick="forcompleted(${response.history6[0].id})">

        //           <div class="svg-wrapper-1">
        //               <div class="svg-wrapper">
        //                   <svg  viewBox="0 0 24 24"
        //                   width="24"
        //                   height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="#ffffff"></path> </g></svg>
        //               </div>
        //           </div>
        //           <span>Mark as Completed</span>
        //           </button>
        //   </form>
        // `;

        // $('#respondingModal1Footer').append(pendingFooter);
        initMap('map' + response.history6[0].incident.id, response.history6[0].incident.latitude, response.history6[0].incident.longitude, response.history6[0].incident.id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function receivedModal(id) {
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
        $('#receivedModalBody').empty();
        $('#receivedModal').modal('show');
        var incidentHtml = `
            <!-- Google Map Container -->
            <div id="map${response.history7[0].incident.id}" style="height: 350px;">
            </div>
          
            <!-- Rest of the modal content -->
            <hr class="style-one">
            <div class="square-container mt-2 p-20">
                <div class="shadow p-3 mb-1 rounded modalInfo">
                    <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${response.history7[0].created_at}</h5>
                    <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history7[0].incident.type}</h5>
                    <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history7[0].incident.user.first_name} ${response.history7[0].incident.user.last_name}</h5>
                    <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: ${response.history7[0].incident.user.age}</h5>
                    <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: ${response.history7[0].barangay}</h5>
                    <h5 id="address${response.history7[0].incident.id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                </div>
            </div>
        `;
        $('#receivedModalBody').append(incidentHtml);

        
        initMap('map' + response.history7[0].incident.id, response.history7[0].incident.latitude, response.history7[0].incident.longitude, response.history7[0].incident.id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}

function reportModal(id) {
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
        $('#reportModalBody').empty();
        $('#reportModal').modal('show');
        var incidentHtml = `
        <div class="square-container p-20">
          <div class="shadow p-1 mb-1 bg-white rounded">
          <div class="container row ps-5">
          <img src="{{asset('file/' + ${response.history8[0].file})}}" class="img-thumbnail mt-3" alt="...">
        <form class="row gt-3 gx-3" action="" method="">
        
        <div class="col-md-6 mt-3">
            <label for="inputName" class="form-label mb-0">Name</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputName" name="id" value="${response.history8[0].user.first_name} ${response.history8[0].user.last_name}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPhone" class="form-label mb-0 fs-6">Phone Number</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPhone" name="id" value="${response.history8[0].user.contact_no}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPassword4" class="form-label mb-0 fs-6">Date</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history8[0].datehappened}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-12 mt-3">
            <label for="inputAddress" class="form-label mb-0">Location</label>                                     
        </div>
          <div id="map${response.history8[0].id}" style="height: 350px;">
            </div>

            
        <div class="col-12 mt-3">
            <label for="exampleFormControlTextarea1" class="form-label">Incident Details</label>
            <textarea class="form-control border-2 border-dark-subtle align-left" id="exampleFormControlTextarea1"  name="ticket_body" rows="3" aria-label="Disabled input example" disabled readonly>${response.history8[0].details}</textarea>
        </div>
        <div class="col-12 mt-3 mb-3">
            <label for="inputAddress" class="form-label mb-0">Additional Notes</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history8[0].addnotes}" aria-label="Disabled input example" disabled readonly>
        </div>
        
        
        </form>
        </div>
            
        </div>
    </div>
        `;
        $('#reportModalBody').append(incidentHtml);

        $('#reportModalFooter').empty();
        var pendingFooter = `
            <form action="" method="POST">
                <button class="respondBtn" type="button" onclick="responding(${response.history8[0].id})">
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
                <button class="forwardBtn" type="button" onclick="forwarded(${response.history8[0].id})">
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

        $('#reportModalFooter').append(pendingFooter);
        initMap('map' + response.history8[0].id, response.history8[0].latitude, response.history8[0].longitude, response.history8[0].id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function reportModal1(id) {
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
        $('#reportModal1Body').empty();
        $('#reportModal1').modal('show');
        var incidentHtml = `
        <div class="square-container p-20">
          <div class="shadow p-1 mb-1 bg-white rounded">
          <div class="container row ps-5">
          <img src="{{asset('file/' + ${response.history9[0].file})}}" class="img-thumbnail mt-3" alt="...">
        <form class="row gt-3 gx-3" action="" method="">
        
        <div class="col-md-6 mt-3">
            <label for="inputName" class="form-label mb-0">Name</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputName" name="id" value="${response.history9[0].report.user.first_name} ${response.history9[0].report.user.last_name}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPhone" class="form-label mb-0 fs-6">Phone Number</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPhone" name="id" value="${response.history9[0].report.user.contact_no}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPassword4" class="form-label mb-0 fs-6">Date</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history9[0].report.datehappened}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-12 mt-3">
            <label for="inputAddress" class="form-label mb-0">Location</label>                                     
        </div>
          <div id="map${response.history9[0].id}" style="height: 350px;">
            </div>

            
        <div class="col-12 mt-3">
            <label for="exampleFormControlTextarea1" class="form-label">Incident Details</label>
            <textarea class="form-control border-2 border-dark-subtle align-left" id="exampleFormControlTextarea1"  name="ticket_body" rows="3" aria-label="Disabled input example" disabled readonly>${response.history9[0].report.details}</textarea>
        </div>
        <div class="col-12 mt-3 mb-3">
            <label for="inputAddress" class="form-label mb-0">Additional Notes</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history9[0].report.addnotes}" aria-label="Disabled input example" disabled readonly>
        </div>
        
        
        </form>
        </div>
            
        </div>
    </div>
        `;
        $('#reportModal1Body').append(incidentHtml);

        $('#reportModal1Footer').empty();
        var pendingFooter = `
            <form action="" method="POST">
                <button class="respondBtn" type="button" onclick="respondreport(${response.history9[0].id})">
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
                <button class="forwardBtn" type="button" onclick="reforwarded(${response.history9[0].id})">
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

        $('#reportModal1Footer').append(pendingFooter);
        initMap('map' + response.history9[0].id, response.history9[0].latitude, response.history9[0].longitude, response.history9[0].id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}

function respondingreportModal(id) {
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
        $('#resreportModalBody').empty();
        $('#respondingreportModal').modal('show');
        var incidentHtml = `
        <div class="square-container p-20">
          <div class="shadow p-1 mb-1 bg-white rounded">
          <div class="container row ps-5">
          <img src="{{asset('file/' + ${response.history10[0].file})}}" class="img-thumbnail mt-3" alt="...">
        <form class="row gt-3 gx-3" action="" method="">
        
        <div class="col-md-6 mt-3">
            <label for="inputName" class="form-label mb-0">Name</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputName" name="id" value="${response.history10[0].user.first_name} ${response.history10[0].user.last_name}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPhone" class="form-label mb-0 fs-6">Phone Number</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPhone" name="id" value="${response.history10[0].user.contact_no}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPassword4" class="form-label mb-0 fs-6">Date</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history10[0].datehappened}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-12 mt-3">
            <label for="inputAddress" class="form-label mb-0">Location</label>                                     
        </div>
          <div id="map${response.history10[0].id}" style="height: 350px;">
            </div>

            
        <div class="col-12 mt-3">
            <label for="exampleFormControlTextarea1" class="form-label">Incident Details</label>
            <textarea class="form-control border-2 border-dark-subtle align-left" id="exampleFormControlTextarea1"  name="ticket_body" rows="3" aria-label="Disabled input example" disabled readonly>${response.history10[0].details}</textarea>
        </div>
        <div class="col-12 mt-3 mb-3">
            <label for="inputAddress" class="form-label mb-0">Additional Notes</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history10[0].addnotes}" aria-label="Disabled input example" disabled readonly>
        </div>
        
        
        </form>
        </div>
            
        </div>
    </div>
        `;
        $('#resreportModalBody').append(incidentHtml);

        $('#resreportModalFooter').empty();
        var pendingFooter = `
            <form action="" method="POST">
                <button class="completeBtn" type="button" onclick="completing(${response.history10[0].id})">
                    <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                            <svg  viewBox="0 0 24 24"
                            width="24"
                            height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="#ffffff"></path> </g></svg>
                        </div>
                    </div>
                    <span>Mark as Completed</span>
                    </button>
            </form>
        `;

        $('#resreportModalFooter').append(pendingFooter);
        initMap('map' + response.history10[0].id, response.history10[0].latitude, response.history10[0].longitude, response.history10[0].id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function respondingreportModal1(id) {
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
        $('#respondingreportModal1Body').empty();
        $('#respondingreportModal1').modal('show');
        var incidentHtml = `
        <div class="square-container p-20">
          <div class="shadow p-1 mb-1 bg-white rounded">
          <div class="container row ps-5">
          <img src="{{asset('file/' + ${response.history11[0].file})}}" class="img-thumbnail mt-3" alt="...">
        <form class="row gt-3 gx-3" action="" method="">
        
        <div class="col-md-6 mt-3">
            <label for="inputName" class="form-label mb-0">Name</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputName" name="id" value="${response.history11[0].report.user.first_name} ${response.history11[0].report.user.last_name}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPhone" class="form-label mb-0 fs-6">Phone Number</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPhone" name="id" value="${response.history11[0].report.user.contact_no}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPassword4" class="form-label mb-0 fs-6">Date</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history11[0].report.datehappened}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-12 mt-3">
            <label for="inputAddress" class="form-label mb-0">Location</label>                                     
        </div>
          <div id="map${response.history11[0].id}" style="height: 350px;">
            </div>

            
        <div class="col-12 mt-3">
            <label for="exampleFormControlTextarea1" class="form-label">Incident Details</label>
            <textarea class="form-control border-2 border-dark-subtle align-left" id="exampleFormControlTextarea1"  name="ticket_body" rows="3" aria-label="Disabled input example" disabled readonly>${response.history11[0].report.details}</textarea>
        </div>
        <div class="col-12 mt-3 mb-3">
            <label for="inputAddress" class="form-label mb-0">Additional Notes</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history11[0].report.addnotes}" aria-label="Disabled input example" disabled readonly>
        </div>
        
        
        </form>
        </div>
            
        </div>
    </div>
        `;
        $('#respondingreportModal1Body').append(incidentHtml);

        $('#respondingreportModal1Footer').empty();
        var pendingFooter = `
        <form action="" method="POST">
        <button class="completeBtn" type="button" onclick="completedreport(${response.history10[0].id})">
            <div class="svg-wrapper-1">
                <div class="svg-wrapper">
                    <svg  viewBox="0 0 24 24"
                    width="24"
                    height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="#ffffff"></path> </g></svg>
                </div>
            </div>
            <span>Mark as Completed</span>
            </button>
    </form>
        `;

        $('#respondingreportModal1Footer').append(pendingFooter);
        initMap('map' + response.history11[0].id, response.history11[0].latitude, response.history11[0].longitude, response.history11[0].id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}

function reportsForModal(id) {
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
        $('#reportsForModalBody').empty();
        $('#reportsForModal').modal('show');
        var incidentHtml = `
        <div class="square-container p-20">
          <div class="shadow p-1 mb-1 bg-white rounded">
          <div class="container row ps-5">
          <img src="{{asset('file/' + ${response.history12[0].file})}}" class="img-thumbnail mt-3" alt="...">
        <form class="row gt-3 gx-3" action="" method="">
        
        <div class="col-md-6 mt-3">
            <label for="inputName" class="form-label mb-0">Name</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputName" name="id" value="${response.history12[0].user.first_name} ${response.history12[0].user.last_name}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPhone" class="form-label mb-0 fs-6">Phone Number</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPhone" name="id" value="${response.history12[0].user.contact_no}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPassword4" class="form-label mb-0 fs-6">Date</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history12[0].datehappened}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-12 mt-3">
            <label for="inputAddress" class="form-label mb-0">Location</label>                                     
        </div>
          <div id="map${response.history12[0].id}" style="height: 350px;">
            </div>

            
        <div class="col-12 mt-3">
            <label for="exampleFormControlTextarea1" class="form-label">Incident Details</label>
            <textarea class="form-control border-2 border-dark-subtle align-left" id="exampleFormControlTextarea1"  name="ticket_body" rows="3" aria-label="Disabled input example" disabled readonly>${response.history12[0].details}</textarea>
        </div>
        <div class="col-12 mt-3 mb-3">
            <label for="inputAddress" class="form-label mb-0">Additional Notes</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history12[0].addnotes}" aria-label="Disabled input example" disabled readonly>
        </div>
        
        
        </form>
        </div>
            
        </div>
    </div>
        `;
        $('#reportsForModalBody').append(incidentHtml);

       
        initMap('map' + response.history12[0].id, response.history12[0].latitude, response.history12[0].longitude, response.history8[0].id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function reportsForModal1(id) {
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
        $('#reportsForModal1Body').empty();
        $('#reportsForModal1').modal('show');
        var incidentHtml = `
        <div class="square-container p-20">
          <div class="shadow p-1 mb-1 bg-white rounded">
          <div class="container row ps-5">
          <img src="{{asset('file/' + ${response.history13[0].file})}}" class="img-thumbnail mt-3" alt="...">
        <form class="row gt-3 gx-3" action="" method="">
        
        <div class="col-md-6 mt-3">
            <label for="inputName" class="form-label mb-0">Name</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputName" name="id" value="${response.history13[0].report.user.first_name} ${response.history13[0].report.user.last_name}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPhone" class="form-label mb-0 fs-6">Phone Number</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPhone" name="id" value="${response.history13[0].report.user.contact_no}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPassword4" class="form-label mb-0 fs-6">Date</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history13[0].report.datehappened}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-12 mt-3">
            <label for="inputAddress" class="form-label mb-0">Location</label>                                     
        </div>
          <div id="map${response.history13[0].id}" style="height: 350px;">
            </div>

            
        <div class="col-12 mt-3">
            <label for="exampleFormControlTextarea1" class="form-label">Incident Details</label>
            <textarea class="form-control border-2 border-dark-subtle align-left" id="exampleFormControlTextarea1"  name="ticket_body" rows="3" aria-label="Disabled input example" disabled readonly>${response.history13[0].report.details}</textarea>
        </div>
        <div class="col-12 mt-3 mb-3">
            <label for="inputAddress" class="form-label mb-0">Additional Notes</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history13[0].report.addnotes}" aria-label="Disabled input example" disabled readonly>
        </div>
        
        
        </form>
        </div>
            
        </div>
    </div>
        `;
        $('#reportsForModal1Body').append(incidentHtml);

        
        initMap('map' + response.history13[0].id, response.history13[0].latitude, response.history13[0].longitude, response.history13[0].id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}

function comReportsModal(id) {
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
        $('#comReportsModalBody').empty();
        $('#comReportsModal').modal('show');
        var incidentHtml = `
        <div class="square-container p-20">
          <div class="shadow p-1 mb-1 bg-white rounded">
          <div class="container row ps-5">
          <img src="{{asset('file/' + ${response.history12[0].file})}}" class="img-thumbnail mt-3" alt="...">
        <form class="row gt-3 gx-3" action="" method="">
        
        <div class="col-md-6 mt-3">
            <label for="inputName" class="form-label mb-0">Name</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputName" name="id" value="${response.history12[0].user.first_name} ${response.history12[0].user.last_name}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPhone" class="form-label mb-0 fs-6">Phone Number</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPhone" name="id" value="${response.history12[0].user.contact_no}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPassword4" class="form-label mb-0 fs-6">Date</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history12[0].datehappened}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-12 mt-3">
            <label for="inputAddress" class="form-label mb-0">Location</label>                                     
        </div>
          <div id="map${response.history12[0].id}" style="height: 350px;">
            </div>

            
        <div class="col-12 mt-3">
            <label for="exampleFormControlTextarea1" class="form-label">Incident Details</label>
            <textarea class="form-control border-2 border-dark-subtle align-left" id="exampleFormControlTextarea1"  name="ticket_body" rows="3" aria-label="Disabled input example" disabled readonly>${response.history12[0].details}</textarea>
        </div>
        <div class="col-12 mt-3 mb-3">
            <label for="inputAddress" class="form-label mb-0">Additional Notes</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history12[0].addnotes}" aria-label="Disabled input example" disabled readonly>
        </div>
        
        
        </form>
        </div>
            
        </div>
    </div>
        `;
        $('#comReportsModalBody').append(incidentHtml);

       
        initMap('map' + response.history12[0].id, response.history12[0].latitude, response.history12[0].longitude, response.history8[0].id);
      
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function comReportsModal1(id) {
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
        $('#comReportsModal1Body').empty();
        $('#comReportsModal1').modal('show');
        var incidentHtml = `
        <div class="square-container p-20">
          <div class="shadow p-1 mb-1 bg-white rounded">
          <div class="container row ps-5">
          <img src="{{asset('file/' + ${response.history13[0].file})}}" class="img-thumbnail mt-3" alt="...">
        <form class="row gt-3 gx-3" action="" method="">
        
        <div class="col-md-6 mt-3">
            <label for="inputName" class="form-label mb-0">Name</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputName" name="id" value="${response.history13[0].report.user.first_name} ${response.history13[0].report.user.last_name}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPhone" class="form-label mb-0 fs-6">Phone Number</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPhone" name="id" value="${response.history13[0].report.user.contact_no}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-md-3 mt-3">
            <label for="inputPassword4" class="form-label mb-0 fs-6">Date</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history13[0].report.datehappened}" aria-label="Disabled input example" disabled readonly>
        </div>
        <div class="col-12 mt-3">
            <label for="inputAddress" class="form-label mb-0">Location</label>                                     
        </div>
          <div id="map${response.history13[0].id}" style="height: 350px;">
            </div>

            
        <div class="col-12 mt-3">
            <label for="exampleFormControlTextarea1" class="form-label">Incident Details</label>
            <textarea class="form-control border-2 border-dark-subtle align-left" id="exampleFormControlTextarea1"  name="ticket_body" rows="3" aria-label="Disabled input example" disabled readonly>${response.history13[0].report.details}</textarea>
        </div>
        <div class="col-12 mt-3 mb-3">
            <label for="inputAddress" class="form-label mb-0">Additional Notes</label>
            <input type="text" class="form-control border-2 border-dark-subtle" id="inputPassword4" name="id" value="${response.history13[0].report.addnotes}" aria-label="Disabled input example" disabled readonly>
        </div>
        
        
        </form>
        </div>
            
        </div>
    </div>
        `;
        $('#comReportsModal1Body').append(incidentHtml);

        
        initMap('map' + response.history13[0].id, response.history13[0].latitude, response.history13[0].longitude, response.history13[0].id);
      
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
                    addressElement.innerHTML = '<i class="bi bi-house-down-fill modalIcon"></i>Specific Location: ' + results[1].formatted_address;
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