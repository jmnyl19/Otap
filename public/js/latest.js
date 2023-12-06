$(document).ready(function () {
    getReport();
    getForwardedReport();
  });

  function getReport() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getreport',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.reports.length === 0) {
          var incidentHtml = '';
          
          incidentHtml += `
              <div class="btn btn-primary shadow p-4 mb-1 bg-white rounded" type="button" style="width: 100%; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              
                          </div>
                          <div class="col">
                              <h6 style="color: #ababab; text-align: center;" ><i>No reported incidents!</i><span class="fw-bold"></span></h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;

          $('#getReportsCont').append(incidentHtml);
        } else {
        $.each(response.reports, function(index, value) {
          var date = moment(value.created_at).format('lll');
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="reportModal(${value.id})" style="width: 100%; margin: 10px; border: none">
            <div class="card-body">
                <div class="row align-items-center text-start">
                    <div class="col-auto">
                        <h1 style="color: red">|</h1>
                    </div>
                    <div class="col">
                        <h6 style="color: #000"><span class="fw-bold">(${date})</span></h6>
                    </div>
                </div>
            </div>
        </div>
        `;
          
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#getReportsCont').append(incidentHtml);
          });
        }
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
        url: '/pendingreport/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          var imagePath = 'file/' + response.history8[0].file;
          $('#reportModalBody').empty();
          $('#reportModal').modal('show');
          var incidentHtml = `
          <div class="square-container p-20">
            <div class="shadow p-1 mb-1 bg-white rounded">
            <div class="container row ps-5">
            <img src="${imagePath}" class="img-thumbnail mt-3" alt="...">
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
          initMap('map' + response.history8[0].id, parseFloat(response.history8[0].latitude), parseFloat(response.history8[0].longitude), response.history8[0].id);
        
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
        url: '/forwardedreport/' + id,
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
            <img src="file/${response.history9[0].file}" class="img-thumbnail mt-3" alt="...">
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
          initMap('map' + response.history9[0].id, parseFloat(response.history9[0].latitude), parseFloat(response.history9[0].longitude), response.history9[0].id);
        
        },
        error: function (error) {
            console.log('Error fetching latest incidents:', error);
        }
    });
  }

  function getForwardedReport() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getforwardedreport',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.forreports.length === 0) {
          var incidentHtml = '';
          
          incidentHtml += `
              <div class="btn btn-primary shadow p-4 mb-1 bg-white rounded" type="button" style="width: 100%; border: none">
                  <div class="card-body">
                      <div class="row align-items-center text-start">
                          <div class="col-auto">
                              
                          </div>
                          <div class="col">
                              <h6 style="color: #ababab; text-align: center;" ><i>No incidents received from other barangay!</i><span class="fw-bold"></span></h6>
                          </div>
                      </div>
                  </div>
              </div>
            `;

          $('#getReceivedReportsCont').append(incidentHtml);
        } else {
        $.each(response.forreports, function(index, value) {
            var date = moment(value.created_at).format('lll');
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="reportModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
            <div class="card-body">
                <div class="row align-items-center text-start">
                    <div class="col-auto">
                        <h1 style="color: red">|</h1>
                    </div>
                    <div class="col">
                        <h6 style="color: #000"><span class="fw-bold">(${date})</span></h6>
                    </div>
                </div>
            </div>
        </div>
        `;
          
        // Append the HTML to the container (replace 'your-container' with the actual container ID or class)
        $('#getReceivedReportsCont').append(incidentHtml);
          });
        }
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
  }

  var maps = [];


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