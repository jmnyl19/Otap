$(document).ready(function () {
  var respondersTable = $('#allRespondersCont').DataTable();

  getResponders(respondersTable);
  addResponders();
});

function getResponders(respondersTable) {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
      url: '/getresponders',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
          respondersTable.clear();


          $.each(response.responders, function (index, value) {
              
              var rowData = [
                  value.responder,
                  value.number,
                  `<button type="button" class="btn btn-primary" onclick="edit(${value.id})">Edit</button> 
                   <button type="button" class="btn btn-danger" onclick="deleteresponder(${value.id})">Delete</button>`
              ];

              respondersTable.row.add(rowData);
          });

          respondersTable.draw();
      },
      error: function (error) {
          console.log('Error fetching latest incidents:', error);
      }
  });
}
function addResponders() {
    var htmlForm = `
            <div>
                <h6 class="text-center fw-bold">FORM</h6>
            </div>
            <form id="textAlertForm">
                <div class="mb-3">
                    <label for="responder" class="form-label mb-0">Responder</label>
                    <select id="responder" name="responder" class="form-select" required>
                        <option value="" selected>Select Responder</option>
                        <option value="Ambulance">Ambulance</option>
                        <option value="Firetruck">Firetruck</option>
                        <option value="Bpat">Bpat</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label mb-0">Contact Number</label>
                    <input type="text" class="form-control" id="number" name="number" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="submitTextAlertForm()">Submit</button>
            </form>
    `;

    $('#editRespondersCont').html(htmlForm);
}

function submitTextAlertForm() {
    var selectedResponder = $('#responder').val();
    var number = $('#number').val();
    Swal.fire({
        title: 'Confirmation',
        text: 'Are you sure you want to add this contact number?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        background: '#fff',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#4BB1F7',
        cancelButtonColor: '#c2c2c2',
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed) {
            if (!number || selectedResponder==='') {
                Swal.fire({
                  title: 'Error!',
                  text: 'Please select a responder and enter a contact number.',
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
                url: '/addresponders',
                type: 'POST',
                dataType: 'json',
                data: {
                    responder: selectedResponder,
                    number: number
                },
                success: function (response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Success!',
                        text: 'Responders contact number added successfully.',
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
                        text: 'Failed to add responders contact number. Please select responder and add a contact number.',
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

function edit(responderId) {
    $.ajax({
        url: '/geteditresponder/' + responderId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {

            if (response.responder) {
                var responder = response.responder;

                $('#responder').val(responder.responder);
                $('#number').val(responder.number);

                var htmlForm = `
                    <form id="textAlertForm">
                        <div class="mb-3">
                            <label for="responder" class="form-label">Responder</label>
                            <select id="responder" name="responder" class="form-select" required>
                                <option value="" selected>Select Responder</option>
                                <option value="Ambulance" ${responder.responder === 'Ambulance' ? 'selected' : ''}>Ambulance</option>
                                <option value="Firetruck" ${responder.responder === 'Firetruck' ? 'selected' : ''}>Firetruck</option>
                                <option value="Bpat" ${responder.responder === 'Bpat' ? 'selected' : ''}>Bpat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="number" name="number" value="${responder.number}" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="updateResponders(${responder.id})">Update</button>
                    </form>
                `;

                $('#editRespondersCont').html(htmlForm);
            } else {
                console.log('Invalid data received for editing responder.');
            }
        },
        error: function (error) {
            console.log('Error fetching responder details:', error);
        }
    });
}

function updateResponders(responderId) {
    var selectedResponder = $('#responder').val();
    var number = $('#number').val();

    Swal.fire({
        title: 'Confirmation',
        text: 'Are you sure you want to update this information?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        background: '#fff',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#4BB1F7',
        cancelButtonColor: '#c2c2c2',
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed) {
            if (selectedResponder === '' || number === '') {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select a responder and enter a number.',
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
                url: '/updateresponder/' + responderId,
                type: 'POST',
                dataType: 'json',
                data: {
                    responder: selectedResponder,
                    number: number
                },
                success: function (response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Success!',
                        text: 'Responders contact number updated successfully.',
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
                        text: 'Failed to update responders contact number. Please select responder and add a contact number.',
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

function deleteresponder(responderId) {
    Swal.fire({
        title: 'Confirmation',
        text: 'Are you sure you want to delete this responder?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        background: '#fff',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#4BB1F7',
        cancelButtonColor: '#c2c2c2',
        reverseButtons: true,

    }).then((result) => {
        if (result.isConfirmed) {
           
            $.ajax({
                url: '/deleteresponder/' + responderId,
                type: 'DELETE',
                dataType: 'json',
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Responder has been deleted successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#4BB1F7',
                        background: '#fff',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr, status, error) {
                    console.log('Error deleting responder:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete responder.',
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

      

