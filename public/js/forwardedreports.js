$(document).ready(function () {
    getForwardedReport();
    getReForwardedReport();
  });

  function getForwardedReport() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getforwardreport',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.foreport.length === 0) {
            var incidentHtml = '';
            
            incidentHtml += `
                <div class="btn btn-primary shadow p-4 mb-1 bg-white rounded" type="button" style="width: 100%; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                
                            </div>
                            <div class="col">
                                <h6 style="color: #ababab; text-align: center;" ><i>No incidents forwarded to other barangay!</i><span class="fw-bold"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
  
            $('#reportForwarded').append(incidentHtml);
          } else {
        $.each(response.foreport, function(index, value) {
            var date = moment(value.created_at).format('lll');
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="reportsForModal(${value.id})" style="width: 100%; margin: 10px; border: none">
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
          
        $('#reportForwarded').append(incidentHtml);
          });
        }
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
  }

  function getReForwardedReport() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getreforwardreport',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        console.log(response);
        $.each(response.reforwarded, function(index, value) {
            var date = moment(value.created_at).format('lll');
            var incidentHtml = `
            <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="reportsForModal1(${value.id})" style="width: 100%; margin: 10px; border: none">
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
          
        $('#reportForwarded1').append(incidentHtml);
          });
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
        url: '/forwardreport/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
        var imagePath = 'file/' + response.history12[0].file;

            console.log(response);
          $('#reportsForModalBody').empty();
          $('#reportsForModal').modal('show');
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
          $('#reportsForModalBody').append(incidentHtml);
  
         
          initMap('map' + response.history12[0].id, parseFloat(response.history12[0].latitude), parseFloat(response.history12[0].longitude), response.history12[0].id);
        
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
        url: '/reforwardreport/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var imagePath = 'file/' + response.history13[0].report.file;

            console.log(response);
            
          $('#reportsForModal1Body').empty();
          $('#reportsForModal1').modal('show');
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
          $('#reportsForModal1Body').append(incidentHtml);
  
          
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