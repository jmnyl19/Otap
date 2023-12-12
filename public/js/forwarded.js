$(document).ready(function () {
    getForwarded();
    getreForwarded();
  });

  function getForwarded() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getforwarded',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        console.log(response);
        if (response.forincidents.length === 0) {
            var emptyHtml = '';
            
            emptyHtml += `
                <div class="btn btn-primary shadow p-4 mb-1 bg-white rounded" type="button" style="width: 100%; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                
                            </div>
                            <div class="col">
                                <h6 style="color: #ababab; text-align: center;" ><i>No forwarded emergency!</i><span class="fw-bold"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
            
            $('#ForwardedCont').append(emptyHtml);
          } else {
        $.each(response.forincidents, function(index, value) {
            
            var date = moment(value.created_at).format('lll');
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
                                <h6 style="color: #000"><span class="fw-bold">(${date})</span> ${value.type}</h6>
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
                              <h6 style="color: #000"><span class="fw-bold">(${date})</span> ${value.type}</h6>
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
                                <h6 style="color: #000"><span class="fw-bold">(${date})</span> ${value.type}</h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
            
          }
  
        $('#ForwardedCont').append(incidentHtml);
          });
        }
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
  }
  function getreForwarded() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getreforwarded',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
    
        $.each(response.forincidents, function(index, value) {
            var date = moment(value.created_at).format('lll');
            var incidentHtml = '';
            if (value.incident.type == 'Requesting for Ambulance') {
              incidentHtml += `
                <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="forwardedModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                <h1 style="color: red">|</h1>
                            </div>
                            <div class="col">
                                <h6 style="color: #000"><span class="fw-bold">(${date})</span> ${value.incident.type}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            } else if (value.incident.type == 'Requesting for a Fire Truck') {
              incidentHtml += `
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="forwardedModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              <h1 style="color: rgb(255, 132, 0)">|</h1>
                          </div>
                          <div class="col">
                              <h6 style="color: #000"><span class="fw-bold">(${date})</span> ${value.incident.type}</h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;
          } else {
            incidentHtml += `
                <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="forwardedModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                <h1 style="color: rgb(0, 157, 255) ">|</h1>
                            </div>
                            <div class="col">
                                <h6 style="color: #000"><span class="fw-bold">(${date})</span> ${value.incident.type}</h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
            
          }
  
        $('#reForwardedCont').append(incidentHtml);
          });
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
        url: '/forwardedincident/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var date = moment(response.history4[0].created_at).format('lll');
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
                      <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${date}</h5>
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
  function forwardedModal1(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/reforwarded/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var date = moment(response.history6[0].created_at).format('lll');
            console.log(response);
          $('#forwardedModal1Body').empty();
          $('#forwardedModal1').modal('show');
          var incidentHtml = `
              <!-- Google Map Container -->
              <div id="map${response.history6[0].incident.id}" style="height: 350px;">
              </div>
            
              <!-- Rest of the modal content -->
              <hr class="style-one">
              <div class="square-container mt-2 p-20">
                  <div class="shadow p-3 mb-1 rounded modalInfo">
                      <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${date}</h5>
                      <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history6[0].incident.type}</h5>
                      <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history6[0].incident.user.first_name} ${response.history6[0].incident.user.last_name}</h5>
                      <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: ${response.history6[0].incident.user.age}</h5>
                      <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: ${response.history6[0].barangay}</h5>
                      <h5 id="address${response.history6[0].incident.id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                  </div>
              </div>
          `;
          $('#forwardedModal1Body').append(incidentHtml);
         initMap('map' + response.history6[0].incident.id, response.history6[0].incident.latitude, response.history6[0].incident.longitude, response.history6[0].incident.id);
        
        },
        error: function (error) {
            console.log('Error fetching latest incidents:', error);
        }
    });
  }
