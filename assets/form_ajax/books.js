

// var create_user = document.getElementById('create_user');
// create_user.addEventListener('click', function (){
//     alert('create_user')
// });

//   alert('clicked');

$(document).ready(function (){

 function validateField(field) {
    if (!field.value || (field.type === 'file' && field.files.length === 0)) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
        return false;
    } else {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        return field;
    }
}

function validateLettersOnly(input) {
 const value = input.value.trim();
    const pattern = /^[A-Za-z]{2,}(?: [A-Za-z]{2,})*$/;

    if (!pattern.test(value)) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        return false;
    }

    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    return true;
}


  $('#create_book_btn').on('click', function (){
      var formData = $('#create_book_form')[0];
      var btn = $(this);
   

    var titleValidate = validateField(formData.title);
     var authorValidate = validateField(formData.author);
     var categoryValidate = validateField(formData.category);
     var total_qtyValidate = validateField(formData.total_qty);
     var isbnValidate = validateField(formData.isbn);
    var cover_imageValidate = validateField(formData.cover_image);

   var etcLttrTitle =  validateLettersOnly(formData.title);
   var etcLttrauthor =  validateLettersOnly(formData.author);
   var etcLttrcategory =  validateLettersOnly(formData.category);



  if (!titleValidate ||
        !authorValidate||
        ! categoryValidate ||
        !total_qtyValidate||
        !isbnValidate||
        !cover_imageValidate) {
          
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'Please fill all the details correctly!'
        });
    
       
        return;
    }

    if (!etcLttrTitle ||
        !etcLttrauthor||
        ! etcLttrcategory) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'letters only, single spaces, min 2 letters per word!'
        });
        
        return;
    }

    if (!formData.checkValidity()) {
    formData.classList.add('was-validated');
    
        return;
        }
     
   btn.prop('disabled', true);
        btn.text('Creating...');
        var data = new FormData(formData);
  var url = $('#create_book_form').attr('action');
data.append('action', 'create_book');



        $.ajax({        
            url: url,
            type: 'POST',
            data: data,
           processData: false,
           contentType: false,
           dataType: 'json',

            success: function (response) {
                if(response.status !== 'success') {

                     Swal.fire({
            icon: 'error',
            title: 'error',
            text: response.message
        })
            btn.prop('disabled', false).text('create');

                }
               else if(response.status === 'success'){

                setTimeout(function() {
                   Swal.fire({
            icon: 'success',
            title: 'success',
            text: response.message
        }).then(()=>{
                        
                     
                    $('.create_book_modal').modal('hide');
                  
                location.reload();
                }, 500);})
                }
                
                
            },
            error: function (response) {
                
                Swal.fire({
            icon: 'error',
            title: 'error',
            text: 'Somthing went wrong'
        })
                 btn.prop('disabled', false).text('create');
            }
        });
        
});

 


$('.edit_book_btn').on('click', function (){

    
    var book_id = $(this).data('id');
    if (!book_id) {
        alert('Book not found!');
        return;
    }

    
$.ajax({
    url: BOOK_AJAX_URL,
    type: 'POST',
    data: { action: 'get_book_details', book_id: book_id },
    dataType: 'json',
    success: function (response) {

        if (response.status !== 'success') return;

        let book = response.data;

        let modalHtml = `
<div class="modal fade edit_book_model scrollShow" id="editBookModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Edit Book</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="edit_book_form" enctype="multipart/form-data">

        <input type="hidden" name="book_id" value="${book.id}">
        <input type="hidden" name="isbn" value="${book.isbn}">
        <input type="hidden" name="old_cover_image" value="${book.cover_image}">

        <div class="modal-body scrollShow-body">

          <label>Title</label>
          <input type="text" name="title" class="form-control" value="${book.title}" pattern="[A-Za-z ]+">
            <div class="invalid-feedback">title is required!</div>
          <label>Author</label>
          <input type="text" name="author" class="form-control" value="${book.author}"  pattern="[A-Za-z ]+">
            <div class="invalid-feedback">author is required!</div>
          <label>Category</label>
          <input type="text" name="category" class="form-control" value="${book.category}" pattern="[A-Za-z ]+">
            <div class="invalid-feedback">category is required!</div>

          

          <label>Total Qty</label>
          <input type="number" name="total_qty" class="form-control" value="${book.total_qty}"  min="0">
          <div class="invalid-feedback">total qty is required!</div>

          <!-- ✅ IS ACTIVE FIELD -->
          <label class="mt-2">Status</label>
          <select name="is_active" class="form-control" required>
            <option value="1" ${book.is_active == 1 ? 'selected' : ''}>Active</option>
            <option value="0" ${book.is_active == 0 ? 'selected' : ''}>Inactive</option>
          </select>
          <div class="invalid-feedback">Please select status!</div>

          
           <br>
            

          <p class="form-control-static" id="staticInput"> <img src="${upload_URL}/${book.cover_image}" width="50" class="rounded" id="coverPreview"></p>
           
          

          <input type="file" name="cover_image" id="cover_image" class="form-control mt-2" accept="image/*">

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary book_update" id="book_update">Update</button>
        </div>

      </form>

    </div>
  </div>
</div>`;

        $('#editBookModal').remove();

        $('body').append(modalHtml);

        new bootstrap.Modal(
            document.getElementById('editBookModal')
        ).show();
    }
});


});

$(document).on('click', '.book_update', function (e) {
    e.preventDefault();

    var btn  = $(this);
    var form = $('#edit_book_form')[0];

   

    var titleValidate    = validateField(form.title);
    var authorValidate   = validateField(form.author);
    var categoryValidate = validateField(form.category);
    var totalQtyValidate = validateField(form.total_qty);
    var isbnValidate     = validateField(form.isbn);

    
   var etcLttrTitle =  validateLettersOnly(form.title);
   var etcLttrauthor =  validateLettersOnly(form.author);
   var etcLttrcategory =  validateLettersOnly(form.category);

    if (!titleValidate ||
        !authorValidate ||
        !categoryValidate ||
        !totalQtyValidate ||
        !isbnValidate) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'Please fill all the details correctly!'
        });
        return;
    }
    if (!etcLttrTitle ||
        !etcLttrauthor ||
        !etcLttrcategory) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'letters only, single spaces, min 2 letters per word!'
        });

        return;
    }
    if (!form.checkValidity()) {
    form.classList.add('was-validated');
    return;
        }
 btn.prop('disabled', true).text('Updating...');
    var formData = new FormData(form);
    formData.append('action', 'update_book');

    $.ajax({
        url: BOOK_AJAX_URL,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        success: function (response) {
            if (response.status !== 'success') {

                 Swal.fire({
            icon: 'error',
            title: 'error',
            text: response.message
        });
                btn.prop('disabled', false).text('Update');
                return;
            } else if (response.status === 'success') {
            

            Swal.fire({
            icon: 'success',
            title: 'success!',
            text: response.message
        }).then(()=>{

            setTimeout(function () {
                $('#editBookModal').modal('hide');
                location.reload();
            }, 500);})
        } },
        error: function () {
           
            Swal.fire({
            icon: 'error',
            title: 'somthing went wrong!',
            text: response.message
        })
            btn.prop('disabled', false).text('Update');
        }
    });
});

$(document).on('click', '.delete_book_btn', function (e) {
    e.preventDefault();
    
    var book_id = $(this).data('id');
     Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'You will not be able to recover this user!',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'

    }).then((result)=>{ 
         if (!result.isConfirmed) return;
    $.ajax({
        url: BOOK_AJAX_URL,
        type: 'POST',
        data: { action: 'delete_book', book_id: book_id },
        dataType: 'json',

        success: function (response) {
            if (response.status !== 'success') {

              Swal.fire({ icon: 'error',
        title: 'error',
        text: response.message})
                return;
            } else if (response.status === 'success'){

            Swal.fire({
        icon: 'success',
        title: 'success',
        text: response.message}).then(()=>{

        
           
            setTimeout(function() {
                location.reload();
            }, 500); });}
        },
        error: function () {
            alert('somthing went wrong');
        }
      });
});
});

});

