$(document).ready(function () {
    getCompletedReport();
    getCompletedForwardedReport();
  });

  function getCompletedReport() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getcompletedreport',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.compreport.length === 0) {
            var incidentHtml = '';
            
            incidentHtml += `
                <div class="btn btn-primary shadow p-4 mb-1 bg-white rounded" type="button" style="width: 100%; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                
                            </div>
                            <div class="col">
                                <h6 style="color: #ababab; text-align: center;" ><i>No completed incidents!</i><span class="fw-bold"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
  
            $('#completedReports').append(incidentHtml);
          } else {
        $.each(response.compreport, function(index, value) {
            var date = moment(value.created_at).format('lll');
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="comReportsModal(${value.id})" style="width: 100%; margin: 10px; border: none">
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
        $('#completedReports').append(incidentHtml);
          });
        }
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
  }

  function getCompletedForwardedReport() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getcompletedforwardedreport',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.compforreport.length === 0) {
            var incidentHtml = '';
            
            incidentHtml += `
                <div class="btn btn-primary shadow p-4 mb-1 bg-white rounded" type="button" style="width: 100%; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                
                            </div>
                            <div class="col">
                                <h6 style="color: #ababab; text-align: center;" ><i>No incidents completed from other barangay!</i><span class="fw-bold"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
  
            $('#completedReports1').append(incidentHtml);
          } else {
        $.each(response.compforreport, function(index, value) {
            var date = moment(value.created_at).format('lll');
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="comReportsModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
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
        $('#completedReports1').append(incidentHtml);
          });
        }
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
        url: '/completedreport/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var imagePath = 'file/' + response.history12[0].file;

            console.log(response);
          $('#comReportsModalBody').empty();
          $('#comReportsModal').modal('show');
          var incidentHtml = `
          <div class="square-container p-20">
            <div class="shadow p-1 mb-1 bg-white rounded">
            <div class="container row ps-5">
            <img src="${imagePath}" class="img-thumbnail mt-3" alt="...">
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
  
         
          initMap('map' + response.history12[0].id, parseFloat(response.history12[0].latitude), parseFloat(response.history12[0].longitude), response.history12[0].id);
        
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
        url: '/completedforwardedreport/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var imagePath = 'file/' + response.history13[0].report.file;

            console.log(response);
          $('#comReportsModal1Body').empty();
          $('#comReportsModal1').modal('show');

          var incidentHtml = `
          <div class="square-container p-20">
            <div class="shadow p-1 mb-1 bg-white rounded">
            <div class="container row ps-5">
            <img src="${imagePath}" class="img-thumbnail mt-3" alt="...">
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
  
          
          initMap('map' + response.history13[0].id, parseFloat(response.history13[0].report.latitude), parseFloat(response.history13[0].report.longitude), response.history13[0].id);
        
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
