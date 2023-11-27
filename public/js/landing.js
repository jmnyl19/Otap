function forward(incidentID) {
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