function forwarded(incidentID) {
  var selectedBarangay = document.getElementById('forwardDropdown').value;
  var incidentStatus = document.getElementById('incidentStatus').value;
  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to forward this emergency?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Forward',
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
        url: '/forwarded/' + incidentID,
        type: 'POST',
        data: {
          report_id: incidentID,
          status: incidentStatus,
          barangay: selectedBarangay
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Emergency has been forwarded successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            location.reload();
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to forward the emergency. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            color: '#fff',
          });
        }
      });
    }
  });
}

function reforward(incidentID1) {
  var selectedBarangay = document.getElementById('forwardDropdown1').value;
  var incidentStatus = document.getElementById('incidentStatus').value;
  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to forward this emergency?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Forward',
    background: '#fff',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#4BB1F7',
    cancelButtonColor: '#c2c2c2',
    
  }).then((result) => {
    if (result.isConfirmed) {
      console.log('incident_id:', incidentID1);
      console.log('status:', incidentStatus);
      console.log('Selected Barangay:', selectedBarangay);
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: '/reforward/' + incidentID1,
        type: 'POST',
        data: {
          incident_id: incidentID1,
          status: incidentStatus,
          barangay: selectedBarangay
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Emergency has been forwarded successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            location.reload();
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to forward the emergency. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            color: '#fff',
          });
        }
      });
    }
  });
}

function reforwarded(incidentID) {
  var selectedBarangay = document.getElementById('forwardDropdown').value;
  var incidentStatus = document.getElementById('incidentStatus').value;
  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to forward this emergency?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Forward',
    background: '#fff',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#4BB1F7',
    cancelButtonColor: '#c2c2c2',
    
  }).then((result) => {
    if (result.isConfirmed) {
      console.log('report_id:', incidentID);
      console.log('status:', incidentStatus);
      console.log('Selected Barangay:', selectedBarangay);
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: '/reforwarded/' + incidentID,
        type: 'POST',
        data: {
          report_id: incidentID,
          status: incidentStatus,
          barangay: selectedBarangay
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Emergency has been forwarded successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            location.reload();
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to forward the emergency. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            color: '#fff',
          });
        }
      });
    }
  });
}

  function raised(complaintId) {
    Swal.fire({
      title: 'Confirmation',
      text: 'Are you sure you want to approve this request?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Approve',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      background: '#222222',
      color: '#FFE1BB',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: '/raised/'+ complaintId,
          type: 'POST',
          
          success: function(response) {
            console.log(response.message); // Handle the success response as per your requirements
            Swal.fire({
              title: 'Approved',
              text: 'Successfully approved this request.',
              icon: 'success',
              iconColor: '#5535d4',
              background: '#222222',
              confirmButtonText: 'Proceed',
              confirmButtonColor: '#3085d6',
              color: '#FFE1BB',
            }).then((result) => {
              // Redirect to the desired page or perform any other desired action
              location.reload();
            });
          },
          error: function(xhr, status, error) {
            console.error(error); // Handle the error response as per your requirements
            Swal.fire({
              title: 'Error',
              text: 'Failed to update.',
              icon: 'error',
              background: '#222222',
              confirmButtonText: 'Proceed',
              confirmButtonColor: '#3085d6',
              color: '#FFE1BB',
            });
          }
        });
      }
    });
  }

  function disregard(complaintId) {
    Swal.fire({
      title: 'Confirmation',
      text: 'Are you sure you want to approve this request?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Approve',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      background: '#222222',
      color: '#FFE1BB',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: '/disregard/'+ complaintId,
          type: 'POST',
          success: function(response) {
            console.log(response.message); // Handle the success response as per your requirements
            Swal.fire({
              title: 'Approved',
              text: 'Successfully approved this request.',
              icon: 'success',
              iconColor: '#5535d4',
              background: '#222222',
              confirmButtonText: 'Proceed',
              confirmButtonColor: '#3085d6',
              color: '#FFE1BB',
            }).then((result) => {
              // Redirect to the desired page or perform any other desired action
              location.reload();
            });
          },
          error: function(xhr, status, error) {
            console.error(error); // Handle the error response as per your requirements
            Swal.fire({
              title: 'Error',
              text: 'Failed to update.',
              icon: 'error',
              background: '#222222',
              confirmButtonText: 'Proceed',
              confirmButtonColor: '#3085d6',
              color: '#FFE1BB',
            });
          }
        });
      }
    });
  }

  function acknowledge(complaintId) {
    Swal.fire({
      title: 'Confirmation',
      text: 'Are you sure you want to approve this request?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Approve',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      background: '#222222',
      color: '#FFE1BB',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: '/acknowledge/'+ complaintId,
          type: 'POST',
          success: function(response) {
            console.log(response.message); // Handle the success response as per your requirements
            Swal.fire({
              title: 'Approved',
              text: 'Successfully approved this request.',
              icon: 'success',
              iconColor: '#5535d4',
              background: '#222222',
              confirmButtonText: 'Proceed',
              confirmButtonColor: '#3085d6',
              color: '#FFE1BB',
            }).then((result) => {
              // Redirect to the desired page or perform any other desired action
              location.reload();
            });
          },
          error: function(xhr, status, error) {
            console.error(error); // Handle the error response as per your requirements
            Swal.fire({
              title: 'Error',
              text: 'Failed to update.',
              icon: 'error',
              background: '#222222',
              confirmButtonText: 'Proceed',
              confirmButtonColor: '#3085d6',
              color: '#FFE1BB',
            });
          }
        });
      }
    });
  }

  function dealt(complaintId) {
    Swal.fire({
      title: 'Confirmation',
      text: 'Are you sure you want to approve this request?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Approve',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      background: '#222222',
      color: '#FFE1BB',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: '/dealt/'+ complaintId,
          type: 'POST',
          success: function(response) {
            console.log(response.message); // Handle the success response as per your requirements
            Swal.fire({
              title: 'Approved',
              text: 'Successfully approved this request.',
              icon: 'success',
              iconColor: '#5535d4',
              background: '#222222',
              confirmButtonText: 'Proceed',
              confirmButtonColor: '#3085d6',
              color: '#FFE1BB',
            }).then((result) => {
              // Redirect to the desired page or perform any other desired action
              location.reload();
            });
          },
          error: function(xhr, status, error) {
            console.error(error); // Handle the error response as per your requirements
            Swal.fire({
              title: 'Error',
              text: 'Failed to update.',
              icon: 'error',
              background: '#222222',
              confirmButtonText: 'Proceed',
              confirmButtonColor: '#3085d6',
              color: '#FFE1BB',
            });
          }
        });
      }
    });
  }