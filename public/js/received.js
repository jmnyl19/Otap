$(document).ready(function () {
    getReceived();
  });

  function getReceived() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getreceived',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        console.log(response);
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
        url: '/receivedincident/' + id,
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
