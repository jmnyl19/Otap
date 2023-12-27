$(document).ready(function () {
    getReceived();
    getResidents();
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
        if (response.receIncidents.length === 0) {
            var incidentHtml = '';
            
            incidentHtml += `
                <div class="btn btn-primary shadow p-4 mb-1 bg-white rounded" type="button" style="width: 100%; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                
                            </div>
                            <div class="col">
                                <h6 style="color: #ababab; text-align: center;" ><i>No emergency received from other barangay!</i><span class="fw-bold"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
  
            $('#allReceivedCont').append(incidentHtml);
          } else {
        $.each(response.receIncidents, function(index, value) {
          var date = moment(value.created_at).format('lll');
            var incidentHtml = '';
    
            if (value.incident.type == 'Requesting for Ambulance') {
              
              incidentHtml += `
                <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="receivedModal(${value.id})" style="width: 100%; margin: 10px; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                <h1 style="color: red">|</h1>
                            </div>
                            <div class="col">
                                <h6 style="color: #000"><span class="fw-bold">(${date})</span> ${value.incident.user.barangay}:  ${value.incident.type} </h6>
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
                                <h6 style="color: #000"><span class="fw-bold">(${date})</span>${value.incident.user.barangay}:  ${value.incident.type}</h6>
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
                                <h6 style="color: #000"><span class="fw-bold">(${date})</span>${value.incident.user.barangay}:   ${value.incident.type}</h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
            }   
          $('#allReceivedCont').append(incidentHtml);
            });
        }
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
          var date = moment(response.history7[0].created_at).format('lll');
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
                      <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${date}</h5>
                      <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history7[0].incident.type}</h5>
                      <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history7[0].incident.user.first_name} ${response.history7[0].incident.user.last_name}</h5>
                      <h5><i class="bi bi-telephone-fill modalIcon"></i>Contact No.: ${response.history7[0].incident.user.contact_no}</h5>
                      <h5><i class="bi bi-calendar-event-fill modalIcon"></i>Age: ${response.history7[0].incident.user.age}</h5>
                      <h5><i class="bi bi-house-down-fill modalIcon"></i>Resident of Barangay: ${response.history7[0].barangay}</h5>
                      <h5 id="address${response.history7[0].incident.id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                  </div>
              </div>
          `;
          $('#receivedModalBody').append(incidentHtml);
  
          
          initMap('map' + response.history7[0].incident.id, parseFloat(response.history7[0].incident.latitude), parseFloat(response.history7[0].incident.longitude), response.history7[0].incident.id);
        
        },
        error: function (error) {
            console.log('Error fetching latest incidents:', error);
        }
    });
  }

  function getResidents() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getresidents',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        var tableBody = $('#allResidentsCont').find('tbody');
        tableBody.empty();
        $.each(response.residents, function(index, value) {
          var statusEditable = `<select name="status" id="status${value.id}" class="selectCont" onchange="editstatus(${value.id})">`;
                
                if (value.status == "Inactive") {
                    statusEditable += `<option value="Inactive" selected>INACTIVE</option>
                                      <option value="Active">ACTIVE</option>
                                      <option value="Ban">BAN</option>`;
                } else if (value.status == "Active") {
                    statusEditable += `<option value="Inactive">INACTIVE</option>
                                      <option value="Active" selected>ACTIVE</option>
                                      <option value="Ban">BAN</option>`;
                } else if (value.status == "Ban") {
                    statusEditable += `<option value="Inactive">INACTIVE</option>
                                      <option value="Active">ACTIVE</option>
                                      <option value="Ban" selected>BAN</option>`;
                }

                statusEditable += `</select>`;
              var row = `
                <tr>
                  
                  <td>${value.first_name} ${value.last_name}</td>
                  <td>${value.age}</td>
                  <td>${value.contact_no}</td>
                  <td>${value.lot_no} ${value.street} ${value.barangay} ${value.city} ${value.province}</td>
                  <td>
                  <button type="button" class="btn btn-primary" onclick="viewDetails(${value.id})">Details</button>
                  </td>
                  <td>${statusEditable}</td>
                  


                </tr>              
              `;
              
              tableBody.append(row);
            });
        
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
  }

  function viewDetails(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/getdetails/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          var imagePath = 'cor/' + response.history7[0].cor;
          var imagePath1 = 'validid/' + response.history7[0].valid_id;


          $('#receivedModalBody').empty();
          $('#viewDetails').modal('show');
          var incidentHtml = `
             
              <div class="square-container mt-2 p-20">
                  <div class="shadow p-3 mb-1 rounded modalInfo">
                      <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history7[0].first_name} ${response.history7[0].last_name}</h5>
                      <h5><i class="bi bi-house-down-fill modalIcon"></i>Address: ${response.history7[0].lot_no} ${response.history7[0].street} ${response.history7[0].barangay} ${response.history7[0].city} ${response.history7[0].province}</h5>
                      <h5><i class="bi bi-file-earmark-text-fill modalIcon"></i>Certificate of Residency:</h5>
                      <img src="${imagePath}" class="img-thumbnail mt-3 mb-3" alt="Certificate of Residency">
                      <h5><i class="bi bi-person-vcard-fill modalIcon"></i>Valid ID:</h5>
                      <img src="${imagePath1}" class="img-thumbnail mt-3" alt="Valid ID">
                  
                  </div>
              </div>
          `;
          $('#receivedModalBody').append(incidentHtml);
  
          
        
        },
        error: function (error) {
            console.log('Error fetching latest incidents:', error);
        }
    });
  }

