$(document).ready(function () {
    getCompleted(1);
  });
  function generatePaginationLinks(pagination) {
    var html = '<ul class="pagination">';
    html += '<li class="page-item ' + (pagination.current_page === 1 ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="getCompleted(' + (pagination.current_page - 1) + ')">Previous</a></li>';
    for (var i = 1; i <= pagination.last_page; i++) {
        html += '<li class="page-item ' + (i === pagination.current_page ? 'active' : '') + '"><a class="page-link" href="#" onclick="getCompleted(' + i + ')">' + i + '</a></li>';
    }
    html += '<li class="page-item ' + (pagination.current_page === pagination.last_page ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="getCompleted(' + (pagination.current_page + 1) + ')">Next</a></li>';
    html += '</ul>';
    return html;
}
  function getCompleted(page) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getcompleted?page=' + page,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        $('#CompletedCont').empty(); 
        if (response.comincidents.length === 0) {
            var incidentHtml = '';
            
            incidentHtml += `
                <div class="btn btn-primary shadow p-4 mb-1 bg-white rounded" type="button" style="width: 100%; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                
                            </div>
                            <div class="col">
                                <h6 style="color: #ababab; text-align: center;" ><i>No completed emergency!</i><span class="fw-bold"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
  
            $('#CompletedCont').append(incidentHtml);
          } else {
        $.each(response.comincidents, function(index, value) {

            var date = moment(value.created_at).format('lll');
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
                                <h6 style="color: #000"><span class="fw-bold">(${date})</span>${value.type}</h6>
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
                              <h6 style="color: #000"><span class="fw-bold">(${date})</span> ${value.type}</h6>
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
                                <h6 style="color: #000"><span class="fw-bold">(${date})</span>${value.type}</h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
            
          }
  
        $('#CompletedCont').append(incidentHtml);
          });
          var paginationHtml = generatePaginationLinks(response.pagination);
          $('#pagination').html(paginationHtml);
          }
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
        url: '/completedincident/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var date = moment(response.history5[0].created_at).format('lll');

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
                      <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${date}</h5>
                      <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history5[0].type}</h5>
                      <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history5[0].user.first_name} ${response.history5[0].user.last_name}</h5>
                      <h5><i class="bi bi-telephone-fill modalIcon"></i>Contact No.: ${response.history5[0].user.contact_no}</h5>
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
