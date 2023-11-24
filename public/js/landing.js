function respondLatest(incidentID) {
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
            url: '/respond/'+incidentID,
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
};