$(document).ready(function () {
  // Initialize DataTable
  var residentsTable = $('#allResidentsCont').DataTable();

  // Call getResidents function with the DataTable instance
  getResidents(residentsTable);
});

var originalStatus = {};

function getResidents(residentsTable) {
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
          // Clear existing data
          residentsTable.clear();

          // Add new data
          $.each(response.residents, function (index, value) {
              originalStatus[value.id] = value.status;
              var remarks = value.remarks || '';

              var statusEditable = `<select name="status" id="status${value.id}" class="selectCont me-2" onchange="editstatus(${value.id})" ${value.status === 'Banned' ? 'disabled' : ''}>`;

              if (value.status == "Inactive") {
                  statusEditable += `<option value="Inactive" selected>INACTIVE</option>
                                    <option value="Active">ACTIVE</option>`;
              } else if (value.status == "Active") {
                  statusEditable += `<option value="Inactive">INACTIVE</option>
                                    <option value="Active" selected>ACTIVE</option>`;
              } else if (value.status == "Banned") {
                  statusEditable += `<option value="Banned" selected>BANNED</option>`;
              }

              statusEditable += `</select>`;

              var banButton = value.status === 'Banned' ?
                  `<button type="button" class="btn btn-primary" onclick="unban(${value.id}, '${remarks}')">Unban</button>` :
                  `<button type="button" class="btn btn-primary" onclick="ban(${value.id})">Ban</button>`;

              var rowData = [
                  `${value.first_name} ${value.last_name}`,
                  value.age,
                  value.contact_no,
                  `${value.lot_no} ${value.street} ${value.barangay} ${value.city} ${value.province}`,
                  `<button type="button" class="btn btn-primary" onclick="viewDetails(${value.id})">Details</button>`,
                  statusEditable,
                  banButton
              ];

              // Add row to DataTable
              residentsTable.row.add(rowData);
          });

          // Draw the table to reflect changes
          residentsTable.draw();
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
          var imagePath2 = 'pfp/' + response.history7[0].profile_picture;

          $('#receivedModalBody').empty();
          $('#viewDetails').modal('show');
          var incidentHtml = `
              <div class="square-container mt-2 p-20">
              <div class="d-flex align-items-center justify-content-center">
                          <img src="${imagePath2}" class="img-thumbnail mt-0 mb-3 rounded-5" alt="Profile Picture">
                        </div>
                  <div class="shadow p-3 mb-1 rounded ">
                          <h5><i class="bi bi-person-circle modalIcon"></i>Name: ${response.history7[0].first_name} ${response.history7[0].last_name}</h5>
                          <h5><i class="bi bi-house-down-fill modalIcon"></i>Address:  ${response.history7[0].lot_no} ${response.history7[0].street} ${response.history7[0].barangay} ${response.history7[0].city} ${response.history7[0].province}</h5>
                          <h5><i class="bi bi-house-down-fill modalIcon"></i>Landmark: ${response.history7[0].landmark}</h5>
                          <h5><i class="bi bi-file-earmark-text-fill modalIcon"></i>Certificate of Residency:
                          <button type="button" class="btn btn-link" data-toggle="modal" data-target="#certificateModal">
                              View COR
                          </button>
                          </h5>
                          
                          <div id="certificateModal" class="modal fade" role="dialog">
                              <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                      <div class="modal-body">
                                          <img src="${imagePath}" class="img-fluid" alt="Certificate of Residency">
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <h5><i class="bi bi-person-vcard-fill modalIcon"></i>Valid ID: <button type="button" class="btn btn-link" data-toggle="modal" data-target="#validIdModal">
                          View Valid ID
                      </button></h5>
                          
                          <div id="validIdModal" class="modal fade" role="dialog">
                              <div class="modal-dialog modal-dialog-centered modal-md">
                                  <div class="modal-content">
                                      <div class="modal-body d-flex align-items-center justify-content-center ">
                                          <img src="${imagePath1}" class="img-fluid" alt="Valid ID">
                                      </div>
                                  </div>
                              </div>
                          </div>
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

  function editstatus(residentId) {
    var selectedStatus = $('#status' + residentId).val();
    var original = originalStatus[residentId];
    Swal.fire({
      title: 'Confirmation',
      text: 'Are you sure you want change status?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Confirm',
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
          url: '/editstatus/' + residentId,
          type: 'POST',
          dataType: 'json',
          data: {
            id: residentId,
            status: selectedStatus
          },
          success: function(response) {
            Swal.fire({
              title: 'Success!',
              text: 'Status has been changed successfully.',
              icon: 'success',
              confirmButtonText: 'OK',
              confirmButtonColor: '#4BB1F7',
              background: '#fff',
            }).then((result) => {
              location.reload(); 
            });
          },
          error: function(xhr, status, error) {
            console.error(error); 
            $('#status' + residentId).val(original);
            Swal.fire({
              title: 'Error!',
              text: 'Failed to change status.',
              icon: 'error',
              confirmButtonText: 'OK',
              confirmButtonColor: '#4BB1F7',
              background: '#fff',
            });
          }
        });
      }else{
        $('#status' + residentId).val(original);
      }
    });
   
  }
  function ban(residentId) {
    var feedbackInput = ''; 

    Swal.fire({
        title: 'Ban Confirmation',
        text: 'Are you sure you want to ban this resident?',
        icon: 'question',
        input: 'text', 
        inputPlaceholder: 'Provide feedback',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        background: '#fff',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#4BB1F7',
        cancelButtonColor: '#c2c2c2',
        preConfirm: (remarks) => {
            feedbackInput = remarks; 
        },
    }).then((result) => {
        if (result.isConfirmed) {
          if (!feedbackInput) {
            Swal.fire({
              title: 'Error!',
              text: 'Please enter a remark.',
              icon: 'error',
              confirmButtonText: 'OK',
              confirmButtonColor: '#4BB1F7',
              background: '#fff',
            });
            return;
          }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/ban/' + residentId,
                type: 'POST',
                dataType: 'json',
                data: {
                    id: residentId,
                    remarks: feedbackInput, 
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Resident has been banned successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#4BB1F7',
                        background: '#fff',
                    }).then((result) => {
                        location.reload();
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to ban the resident.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#4BB1F7',
                        background: '#fff',
                    });
                }
            });
        }
    });
}

function unban(residentId, remarks) {
    Swal.fire({
      title: 'Unbanning Confirmation',
      text: 'Are you sure you want to unban this resident?',
      html: `
            <p class="mb-0 ">Reason for banning:</p>
            <textarea id="remarks" class="swal2-textarea mt-0" readonly>${remarks}</textarea>
        `,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Confirm',
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
              url: '/unban/' + residentId,
              type: 'POST',
              dataType: 'json',
              data: {
                  id: residentId,
              },
              success: function (response) {
                  Swal.fire({
                      title: 'Success!',
                      text: 'Resident has been unbanned successfully.',
                      icon: 'success',
                      confirmButtonText: 'OK',
                      confirmButtonColor: '#4BB1F7',
                      background: '#fff',
                  }).then((result) => {
                      location.reload();
                  });
              },
              error: function (xhr, status, error) {
                  console.error(error);
                  Swal.fire({
                      title: 'Error!',
                      text: 'Failed to unban the resident.',
                      icon: 'error',
                      confirmButtonText: 'OK',
                      confirmButtonColor: '#4BB1F7',
                      background: '#fff',
                  });
              }
          });
      }
  });
}



// function fetchRemarksFunction(residentId) {
//   return 'Sample remarks from the banned resident.';
// }