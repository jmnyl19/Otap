function forward(incidentID) {
  var selectedBarangay = document.getElementById('forwardDropdown').value;
  var incidentStatus = document.getElementById('incidentStatus').value;
  console.log(selectedBarangay);
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
      if (!selectedBarangay) {
        Swal.fire({
          title: 'Error!',
          text: 'Please select a barangay.',
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
        url: '/forward/' + incidentID,
        type: 'POST',
        data: {
          incident_id: incidentID,
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
            window.location.href = '/forwarded'; 
          });
        },
        error: function(xhr, status, error) {
          console.error(error); 
          Swal.fire({
            title: 'Error!',
            text: 'Failed to forward the emergency. Please select a barangay.',
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

function respond(incidentID) {

  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to respond to this emergency?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Respond',
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
        url: '/respond/' + incidentID,
        type: 'POST',
        data: {
          incident_id: incidentID,
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Responded to this emergency successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            window.location.href = '/responding'; 
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to respond to this emergency. Please try again.',
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
      if (!selectedBarangay) {
        Swal.fire({
          title: 'Error!',
          text: 'Please select a barangay.',
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
            window.location.href = '/forwardedreports'; 
          });
        },
        error: function(xhr, status, error) {
          console.error(error); 
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
      if (!selectedBarangay) {
        Swal.fire({
          title: 'Error!',
          text: 'Please select a barangay.',
          icon: 'error',
          confirmButtonText: 'OK',
          confirmButtonColor: '#4BB1F7',
          background: '#fff',
        });
        return;
      }
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
            window.location.href = '/forwarded'; 
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
      if (!selectedBarangay) {
        Swal.fire({
          title: 'Error!',
          text: 'Please select a barangay.',
          icon: 'error',
          confirmButtonText: 'OK',
          confirmButtonColor: '#4BB1F7',
          background: '#fff',
        });
        return;
      }
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
            window.location.href = '/forwardedreports'; 
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
function responded(incidentID) {

  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to respond to this emergency?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Respond',
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
        url: '/responded/' + incidentID,
        type: 'POST',
        data: {
          incident_id: incidentID,
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Responded to this emergency successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            window.location.href = '/responding'; 
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to respond to this emergency. Please try again.',
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
function responding(incidentID) {

  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to respond to this emergency?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Respond',
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
        url: '/responding/' + incidentID,
        type: 'POST',
        data: {
          report_id: incidentID,
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Responded to this emergency successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            window.location.href = '/respondedreports'; 
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to respond to this emergency. Please try again.',
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
function respondreport(incidentID) {

  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to respond to this emergency?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Respond',
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
        url: '/respondreport/' + incidentID,
        type: 'POST',
        data: {
          report_id: incidentID,
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Responded to this emergency successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            window.location.href = '/respondedreports'; 
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to respond to this emergency. Please try again.',
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
function completed(incidentID) {

  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to mark this emergency as completed?',
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
        url: '/completed/' + incidentID,
        type: 'POST',
        data: {
          incident_id: incidentID,
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Responded to this emergency successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            window.location.href = '/completedpage'; 
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to respond to this emergency. Please try again.',
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
function forcompleted(incidentID) {

  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to mark this emergency as completed?',
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
        url: '/forcompleted/' + incidentID,
        type: 'POST',
        data: {
          incident_id: incidentID,
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Responded to this emergency successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            window.location.href = '/completedpage'; 
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to respond to this emergency. Please try again.',
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
function completing(incidentID) {

  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to mark this emergency as completed?',
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
        url: '/completing/' + incidentID,
        type: 'POST',
        data: {
          report_id: incidentID,
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Responded to this emergency successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            window.location.href = '/completedreports'; 
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to respond to this emergency. Please try again.',
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
function completedreport(incidentID) {

  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to mark this emergency as completed?',
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
        url: '/completedreport/' + incidentID,
        type: 'POST',
        data: {
          report_id: incidentID,
        },
        success: function(response) {
          Swal.fire({
            title: 'Success!',
            text: 'Responded to this emergency successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4BB1F7',
            background: '#fff',
          }).then((result) => {
            window.location.href = '/completedreports'; 
          });
        },
        error: function(xhr, status, error) {
          console.error(error); // Handle the error response as per your requirements
          Swal.fire({
            title: 'Error!',
            text: 'Failed to respond to this emergency. Please try again.',
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



  