

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


  $('#create_category_btn').on('click', function (){
      var formData = $('#create_category_form')[0];
      var btn = $(this);

    var name = validateField(formData.name);
     

   var nameSpclLtr =  validateLettersOnly(formData.name);




  if (!name) {
          
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'Please fill details correctly!'
        });
    
       
        return;
    }

    if (!nameSpclLtr) {
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
  var url = $('#create_category_form').attr('action');
data.append('action', 'create_category');



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
                        
                     
                    $('#add_category_modal').modal('hide');
                  
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

 


$('.edit_category_btn').on('click', function (){

    
    var category_id = $(this).data('id');
    if (!category_id) {
      Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'category not found!'
        });
        
        return;
    }

    
$.ajax({
    url: category_AJAX_URL,
    type: 'POST',
    data: { action: 'get_category_details', category_id: category_id },
    dataType: 'json',
    success: function (response) {

        if (response.status !== 'success') return;

        let category = response.data; 

        let modalHtml = `
        <div class="modal fade" id="edit_category_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Book Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="edit_category_form">
                <div class="modal-body">
                <input type="hidden" name="category_id" value="${category.id}">

                    <label>Category Name</label>
                    <input type="text"
                        name="name"
                        class="form-control"
                        placeholder="Category name"
                        value="${category.name}"
                        required>

                    <div class="mt-3">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" ${category.is_active == 1 ? 'selected' : ''}>Active</option>
                            <option value="0" ${category.is_active == 0 ? 'selected' : ''}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_category">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>
`;


         $('#edit_category_modal').remove();

        $('body').append(modalHtml);

        new bootstrap.Modal(
            document.getElementById('edit_category_modal')
        ).show();
        
    }
});


});

$(document).on('click', '#update_category', function (e) {
    e.preventDefault();

    var btn  = $(this);
    var form = $('#edit_category_form')[0];


    var categoryValidate    = validateField(form.name);

   var etcLttrcategory=  validateLettersOnly(form.name);
   

    if (!categoryValidate ) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'Please fill the details correctly!'
        });
        return;
    }
    if (!etcLttrcategory ) {
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
    formData.append('action', 'update_category');
            
    $.ajax({
        url: category_AJAX_URL,
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
                $('#edit_category_modal').modal('hide');
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

$(document).on('click', '.delete_category_btn', function (e) {
    e.preventDefault();
    
    var category_id = $(this).data('id');
     Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'You will not be able to recover this category!',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'

    }).then((result)=>{ 
         if (!result.isConfirmed) return;
    $.ajax({
        url: category_AJAX_URL,
        type: 'POST',
        data: { action: 'delete_category', category_id: category_id },
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

