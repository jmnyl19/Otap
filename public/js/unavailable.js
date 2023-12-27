$(document).ready(function () {
    getForwarded();
  });

  function getForwarded() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getunavailable',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        console.log(response);
        if (response.unavailable.length === 0) {
            var emptyHtml = '';
            
            emptyHtml += `
                <div class="btn btn-primary shadow p-4 mb-1 bg-white rounded" type="button" style="width: 100%; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                
                            </div>
                            <div class="col">
                                <h6 style="color: #ababab; text-align: center;" ><i>No unavailable emergency!</i><span class="fw-bold"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
            
            $('#ForwardedCont').append(emptyHtml);
          } else {
        $.each(response.unavailable, function(index, value) {
            
            var date = moment(value.created_at).format('lll');
            var incidentHtml = '';
            if (value.type == 'Requesting for Ambulance') {
              incidentHtml += `
                <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="unavailableModal(${value.id})" style="width: 100%; margin: 10px; border: none">
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
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="unavailableModal(${value.id})" style="width: 100%; margin: 10px; border: none">
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
                <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="unavailableModal(${value.id})" style="width: 100%; margin: 10px; border: none">
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

  function unavailableModal(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/unavailable/' + id,
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
          $('#forwardedModalFooter').empty();
          var forwardedModalFooter = `
              
              <form action="" method="POST">
                  <button class="respondBtn" type="button" onclick="respond(${response.history4[0].id})">
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
          `;
  
          $('#forwardedModalFooter').append(forwardedModalFooter);
          
         initMap('map' + response.history4[0].id, response.history4[0].latitude, response.history4[0].longitude, response.history4[0].id);
        
        },
        error: function (error) {
            console.log('Error fetching latest incidents:', error);
        }
    });
  }
