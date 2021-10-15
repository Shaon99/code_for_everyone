//Store course by ajax
$(document).ready(function () {
    $(document).on('submit','#add-course-form',function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/admin/postcourse',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (data) {
                $('#name').val('');
                $('#description').val('');
                $('#price').val('');
                $('#image').val('');
                $('#status').val('');
                $('.closeBtn').click();
                document.getElementById("file-id-preview").style.visibility = "hidden";
                iziToast.show({
                    title: 'Course',
                    message: 'Successfully Added',
                    position:'topRight',
                    backgroundColor:'#07b821',
                    titleColor: 'white',
                    messageColor: 'white',
                });
                
                appendTableRow(data);
            },
          
        })
    });
});

//appened table
function appendTableRow(data) {
    $('tbody').append(`
        <tr data-id="${data.id}">
               <td>${data.id}</td>
                <td>${data.name}</td>
                <td>${(data.description).substr(0,20)}</td>
                <td>${data.price}</td>
                <td><img src="/uploads/course_images/${data.image}"></td>
                <td>${data.status}</td>
                <td>
                <a  data-id="${data.id}" data-toggle="modal" data-target="#editcModal" class=" editBtn mdi mdi-pencil-box-outline tip" style="font-size: 25px;color:rgb(13, 27, 221);">
                <span class="tooltiptext h6">Edit</span>  </i></a>&nbsp;&nbsp;&nbsp;               
                <a data-id="${data.id}" class="deletebtn" href="#"><i class="mdi mdi-delete tip"style="font-size: 25px;color:crimson;">
                        <span class="tooltiptext h6">Delete</span>
                    </i></a>                         
               
                </td>
        </tr>
    `);
}
        



//Delete course
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
                    url: `/admin/delete/post/${id}`,
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

//edit
var tableRow = '';
//Show edit form with data ajax request
$(document).ready(function () {
    $(document).on('click','.editBtn',function () {
        const id = $(this).attr('data-id');
        tableRow = $(this).parent().parent();
       $('#course-id').val(id);
        $.ajax({
            type: 'GET',
            url: `/admin/${id}/edit`,
            success: (data) => {
                $('#edit-name').val(data.name);
                $('#edit-description').val(data.description);
                $('#edit-price').val(data.price);
                $('#oldPhoto').attr('src',`../../uploads/course_images/${data.image}`);      
                let op = $('#status option[value='+data.status+']');
                $(op).attr('selected',true);
                let b = $('#status').next().find('.current');
                $(b).text($(op).text());        
            },
            error: (error) => {
                console.log(error);
            }
        })
    });
});

//Update Executive Ajax
$(document).ready(function () {
    $(document).on('submit','#edit-course-form',function (e) {
        e.preventDefault();
        const id = $('#course-id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: `/admin/${id}/update`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (data) {
                $('#edit-name').val(data.name);
                $('#edit-description').val(data.description);
                $('#edit-price').val(data.price);
                $('#edit-image').val('');
                $('#status').val('');
           
                $('.closeBtn').click();
                iziToast.show({
                    title: 'Course',
                    message: 'Successfully Updated',
                    position:'topRight',
                    backgroundColor:'#12e199',
                    titleColor: 'black',
                    messageColor: 'black',

                });
                const a = $(tableRow).find('td');
                $(a[0]).text(data.id);
                $(a[1]).text(data.name);
                $(a[2]).text((data.description).substr(0,20));
                $(a[3]).text(data.price);
                $(a[4]).data.image;
                $(a[5]).text(data.status);


            },
            error: function (error) {
                console.log(error);
            }
        })
    });
});




//picture preview
document.getElementById("file-id-preview").style.visibility = "hidden";
 function showPreview(event){
    if (event.target.files.length > 0) {
      var src = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("file-id-preview");
      preview.src = src;
      preview.style.display = "block";
      document.getElementById("file-id-preview").style.visibility = "visible";
      document.getElementById("file-id-preview").style.height = "200px";
      document.getElementById("file-id-preview").style.width = "300px";


    }
  }

  document.getElementById("file-id-preview1").style.visibility = "hidden";
 function showPreview(event){
    if (event.target.files.length > 0) {
      var src = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("file-id-preview1");
      preview.src = src;
      preview.style.display = "block";
      document.getElementById("file-id-preview1").style.visibility = "visible";
      document.getElementById("file-id-preview1").style.height = "200px";
      document.getElementById("file-id-preview1").style.width = "300px";


    }
  }

