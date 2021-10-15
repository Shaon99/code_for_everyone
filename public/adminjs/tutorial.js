
//Delete tutorial
$(document).ready(function () {
    $(document).on('click', '.deletebtn', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let tableRow = $(this).parent().parent();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success ml-2',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          });

          swalWithBootstrapButtons.fire({              
            title: 'Are you sure?',           
            text: "You won't be able to revert this!",                    
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: `/admin/tutorialpost/${id}`,
                    success: (data) => {
                        $(tableRow).remove();
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                          )

                    },

                })


            }
            else if (
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons.fire(
                  'Cancelled',
                  'Your file is safe :)',
                  'error'
                )
              }



          })

    });

});