$(document).ready(function () {
    getCancelled(1);
  });
  function generatePaginationLinks(pagination) {
    var html = '<ul class="pagination">';
    html += '<li class="page-item ' + (pagination.current_page === 1 ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="getCancelled(' + (pagination.current_page - 1) + ')">Previous</a></li>';
    for (var i = 1; i <= pagination.last_page; i++) {
        html += '<li class="page-item ' + (i === pagination.current_page ? 'active' : '') + '"><a class="page-link" href="#" onclick="getCancelled(' + i + ')">' + i + '</a></li>';
    }
    html += '<li class="page-item ' + (pagination.current_page === pagination.last_page ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="getCancelled(' + (pagination.current_page + 1) + ')">Next</a></li>';
    html += '</ul>';
    return html;
}
  function getCancelled(page) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: '/getcancelled?page=' + page,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        $('#CancelledCont').empty(); 
        if (response.canincidents.length === 0) {
            var incidentHtml = '';
            
            incidentHtml += `
                <div class="btn btn-primary shadow p-4 mb-1 bg-white rounded" type="button" style="width: 100%; border: none">
                    <div class="card-body">
                        <div class="row align-items-center text-start">
                            <div class="col-auto">
                                
                            </div>
                            <div class="col">
                                <h6 style="color: #ababab; text-align: center;" ><i>No cancelled emergency!</i><span class="fw-bold"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
              `;
  
            $('#CancelledCont').append(incidentHtml);
          } else {
        $.each(response.canincidents, function(index, value) {

            var date = moment(value.created_at).format('lll');
            var incidentHtml = '';
            if (value.type == 'Requesting for Ambulance') {
              incidentHtml += `
                <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="cancelledModal(${value.id})" style="width: 100%; margin: 10px; border: none">
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
              <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="cancelledModal(${value.id})" style="width: 100%; margin: 10px; border: none">
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
                <div class="btn btn-primary shadow p-1 mb-1 bg-white rounded" type="button" onclick="cancelledModal(${value.id})" style="width: 100%; margin: 10px; border: none">
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
  
        $('#CancelledCont').append(incidentHtml);
          });
          var paginationHtml = generatePaginationLinks(response.pagination);
          $('#pagination').html(paginationHtml);
          $('#excelButton').append('<button class="btn btn-primary" onclick="exportToExcel(' + page + ')">Export to Excel</button>');

          }
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
  }
  function cancelledModal(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/cancelledincident/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log('Successfully Displayed Details of Cancelled Request');
            var date = moment(response.history15[0].created_at).format('lll');

          $('#cancelledModalBody').empty();
          $('#cancelledModal').modal('show');
          var incidentHtml = `
              
              <div id="map${response.history15[0].id}" style="height: 350px;">
              </div>
            
              
              <hr class="style-one">
              <div class="square-container mt-2 p-20">
                  <div class="shadow p-3 mb-1 rounded modalInfo">
                      <h5><i class="bi bi-calendar2-event-fill modalIcon"></i>Date: ${date}</h5>
                      <h5><i class="bi bi-exclamation-circle-fill modalIcon"></i>Type: ${response.history15[0].type}</h5>
                      <h5><i class="bi bi-person-circle modalIcon" id="name"></i>Name: ${response.history15[0].user.first_name} ${response.history15[0].user.last_name}</h5>
                      <h5><i class="bi bi-telephone-fill modalIcon" id="contact"></i>Contact No.: ${response.history15[0].user.contact_no}</h5>
                      <h5><i class="bi bi-calendar-event-fill modalIcon" id="age"></i>Age: ${response.history15[0].user.age}</h5>
                      <h5><i class="bi bi-house-down-fill modalIcon" id="barangay"></i>Resident of Barangay: ${response.history15[0].user.barangay}</h5>
                      <h5 id="address${response.history15[0].id}" class="address"><i class="bi bi-house-down-fill modalIcon"></i>Specific Location: </h5>
                  </div>
              </div>
          `;
          $('#cancelledModalBody').append(incidentHtml);
  
         initMap('map' + response.history15[0].id, response.history15[0].latitude, response.history15[0].longitude, response.history15[0].id);
        
        },
        error: function (error) {
            console.log('Error fetching latest incidents:', error);
        }
    });
  }

  function exportToExcel(page) {
    $.ajax({
        url: '/getcancelled?page=' + page,  
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            generateAndExportExcel(response.canincidents);
        },
        error: function (error) {
            console.log('Error exporting to Excel:', error);
        }
    });
}
function generateAndExportExcel(data) {
    var modifiedData = data.map(item => {
        
        return {
            Date: moment(item.created_at).format('lll'),
            Type: item.type,
            Name: `${item.user.first_name} ${item.user.last_name}`,
            ContactNo: item.user.contact_no,
            Age: item.user.age,
            Barangay: item.user.barangay,
            latitude:item.latitude,
            longitude: item.longitude,
        };
    });
    var worksheet = XLSX.utils.json_to_sheet(modifiedData);
    var workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Cancelled Incidents');
    XLSX.writeFile(workbook, 'cancelled_incidents.xlsx');
}





