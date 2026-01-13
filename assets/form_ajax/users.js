

// var create_user = document.getElementById('create_user');
// create_user.addEventListener('click', function (){
//     alert('create_user')
// });
//  let fullNameValid = validateField(form.full_name);
//     let phoneValid    = validateField(form.phone_number);
//     let emailValid    = validateField(form.email);
//     let passwordValid = validateField(form.password);
//     let confirmValid  = validateField(form.confirm_password);
//     let roleValid     = validateField(form.role);
//     let fileValid     = validateField(form.profile_image);

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


//   $('#create_user').on('click',function (){
    

 


// })


 $('#create_user_btn').on('click', function () {
    var form = $('#create_user_form')[0];
    var btn = $(this);

    

    // Select inputs
    let fullNameValid = validateField(form.full_name);
    let phoneValid    = validateField(form.phone_number);
    let emailValid    = validateField(form.email);
    let passwordValid = validateField(form.password);
    let confirmValid  = validateField(form.confirm_password);
    let roleValid     = validateField(form.role);
    let fileValid     = validateField(form.profile_image);

     let etc_fullNameValid = validateLettersOnly(form.full_name);

    // Validate each field
    if (!fullNameValid ||
        !phoneValid||
        ! emailValid ||
        !passwordValid||
        !confirmValid||
        !roleValid||
        !fileValid) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'Please fill all the details correctly!'
        });
        return;
    } if(!etc_fullNameValid){
      Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'letters only, single spaces, min 2 letters per word!'
        });
        return;

    }

    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailValid.value.trim())) {
        emailValid.classList.add('is-invalid');
        Swal.fire({
            icon: 'error',
            title: 'Invalid Email',
            text: 'Please enter a valid email!'
        });
        return;
    }

    var phonePattern = /^[0-9]{10,15}$/;
    if (!phonePattern.test(phoneValid.value.trim())) {
        phoneValid.classList.add('is-invalid');
        Swal.fire({
            icon: 'error',
            title: 'Invalid Phone',
            text: 'Phone must be 10-15 digits!'
        });
        return;
    }

    // Password length & match
    if (passwordValid.value.trim().length < 6) {
        passwordValid.classList.add('is-invalid');
        Swal.fire({
            icon: 'error',
            title: 'Weak Password',
            text: 'Password must be at least 6 characters!'
        });
        return;
    }

    if (passwordValid.value !== confirmValid.value) {
        confirmValid.classList.add('is-invalid');
        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'Passwords do not match!'
        });

        return;
    }

    if (!form.checkValidity()) {
    form.classList.add('was-validated');
return;
}        btn.prop('disabled', true);
        btn.text('Creating...');

    var data = new FormData(form);
    data.append('action', 'create_user');

    $.ajax({
        url: form.action,
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
            if (res.status!=='success'){

                Swal.fire({
                icon: 'error',
                title: 'error',
                text: res.message
            })
                  btn.prop('disabled', false);
                  btn.text('Create');

            } else if (res.status=='success'){
                Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.message
            }).then(() => {
                setTimeout(function(){ 
                    
                const modalEl = document.getElementById('create_new_user'); 
    let modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
                location.reload();

                },500)
            });
                
            }
            
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong!'
            });
            btn.prop('disabled', false);
            btn.text('Create');
        }
    });
});



$('.edit_user_btn').on('click', function () {
    var user_id = $(this).data('id'); 
    if (!user_id) {
       Swal.fire({
            icon: 'error',
            title: 'somthing wrong',
            text: 'user not found!'
        });
        return;
    }
    $url = $('#create_user_form').attr('action')
    
    $.ajax({
        url: $url, 
        type: 'POST',
        data: { action: 'get_user_details', user_id: user_id },
        dataType: 'json',
        success: function (response) {

            if (response.status !== 'success') return;

            let user = response.data;

            let modalHtml = `
<div class="modal fade edit_user_modal scrollShow" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Edit User</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="edit_user_form" action="${user_AJAX_URL}" method="post">
        <input type="hidden" name="user_id" value="${user.id}">
        <input type="hidden" name="old_profile_image" value="${user.profile_image}">

        <div class="modal-body scrollShow-body">

          <label>Full Name</label>
          <input type="text" name="full_name" class="form-control" value="${user.name}" required>

          <label>Phone Number</label>
          <input type="number" name="phone_number" class="form-control" value="${user.phone}" required>

          <label>Email</label>
          <input type="text" name="email" class="form-control" value="${user.email}" required>
<label>Password</label>
<div class="position-relative">
  <input type="password" name="password" class="form-control pe-5" placeholder="Enter new password">
  <span class="password-toggle position-absolute" style="top:50%; right:15px; cursor:pointer;">
    <i class="fas fa-eye eye-show"></i>
    <i class="fas fa-eye-slash eye-hide"></i>
  </span>
</div>

<label>Confirm Password</label>
<div class="position-relative">
  <input type="password" name="confirm_password" class="form-control pe-5" placeholder="Confirm password">
  <span class="password-toggle position-absolute" style="top:50%; right:15px; cursor:pointer;">
    <i class="fas fa-eye eye-show"></i>
    <i class="fas fa-eye-slash eye-hide"></i>
  </span>
</div>
 <!-- ✅ IS ACTIVE FIELD -->
          <label class="mt-2">Status</label>
          <select name="is_active" class="form-control" required>
            <option value="1" ${user.is_active == 1 ? 'selected' : ''}>Active</option>
            <option value="0" ${user.is_active == 0 ? 'selected' : ''}>In Active</option>
          </select>
          <div class="invalid-feedback">Please select status!</div>

          <label>Role</label>
<select name="role" class="form-control" required>
  <option value="Admin" ${user.role === 'Admin' ? 'selected' : ''}>Admin</option>
  <option value="Member" ${user.role === 'member' ? 'selected' : ''}>Member</option>
</select>
<br>
        ${user.profile_image?
        `  <p class="form-control-static profile_picture" id="staticInput"> <img src="${upload_URL}/${user.profile_image}"  name="profile" width="50" class="rounded" id="coverPreview"></p>`:
     `<p class="form-control-static " id="staticInput"> <img src="${upload_URL}/default.jpg" width="50" name="profile" class="rounded" id="coverPreview"></p>`}

<div class="mb-3">
    <label for="formFile" class="form-label">Image Upload Here</label>
    <input class="form-control profile_pic" name="profile_picture" type="file" id="formFile">
            </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary update_user">Update</button>
        </div>

      </form>

    </div>
  </div>
</div>
`;

            // Remove old modal if exists
            $('#editUserModal').remove();

            // Append new modal to body
            $('body').append(modalHtml);

            // Show modal
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
            initPasswordToggle('#editUserModal');
        }
    });
});


$(document).on('click', '.update_user', function (e) {
    e.preventDefault();

    let form = $('#edit_user_form')[0];

 let fullNameValid = validateField(form.full_name);

    let phoneValid    = validateField(form.phone_number);
    let emailValid    = validateField(form.email);
    let passwordValid = validateField(form.password);
    let confirmValid  = validateField(form.confirm_password);
    let roleValid     = validateField(form.role);


     let etc_fullNameValid = validateLettersOnly(form.full_name);

   if(!etc_fullNameValid){
      Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'Only letters are allowed!, single spaces, min 2 letters per word!'
        });
        return;

    }
if (!fullNameValid ||
    !phoneValid ||
    !emailValid ||
    !passwordValid ||
    !confirmValid ||
    !roleValid ) {

    Swal.fire({
        icon: 'error',
        title: 'Missing Fields',
        text: 'Please fill all the details correctly!'
    });
    return;
}


    // Additional regex validations
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailValid.value.trim())) {
        emailValid.classList.add('is-invalid');
        Swal.fire({
            icon: 'error',
            title: 'Invalid Email',
            text: 'Please enter a valid email!'
        });
        return;
    }

    var phonePattern = /^[0-9]{10,15}$/;
    if (!phonePattern.test(phoneValid.value.trim())) {
        phoneValid.classList.add('is-invalid');
        Swal.fire({
            icon: 'error',
            title: 'Invalid Phone',
            text: 'Phone must be 10-15 digits!'
        });
        return;
    }

    if (passwordValid.value.trim().length < 6) {
        passwordValid.classList.add('is-invalid');
        Swal.fire({
            icon: 'error',
            title: 'Weak Password',
            text: 'Password must be at least 6 characters!'
        });
        return;
    }

    if (passwordValid.value !== confirmValid.value) {
        confirmValid.classList.add('is-invalid');
        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'Passwords do not match!'
        });
        return;
    }

    if (!form.checkValidity()) {
    form.classList.add('was-validated');
return;
}
         var btn = $(this);
        btn.prop('disabled', true);
        btn.text('Creating...');

    var data = new FormData(form);
 data.append('action', 'update_user');

    $.ajax({
        url: user_AJAX_URL,
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {

            if (response.status !== 'success') {
                Swal.fire({
            icon: 'error',
            title: 'error',
            text: response.message
        }); btn.prop('disabled', false);
        btn.text('Create');
            }
            else if (response.status === 'success') {
                
               Swal.fire({
            icon: 'success',
            title: 'success',
            text: response.message
        }).then(()=>{
          setTimeout(function (){

           $('#editUserModal').modal('hide');
                location.reload()
       
               ;},500) });
            } else {
              Swal.fire({
            icon: 'error',
            title: 'user update fail',
            text: response.message
        });
         btn.prop('disabled', false);
        btn.text('Update');

            }
        },
        error: function () {
            alert('Server error');
        }
    });
});



$(document).on('click', '.delete_user_btn', function () {

    var user_id = $(this).data('id');

    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'You will not be able to recover this user!',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $.ajax({
            url: user_AJAX_URL,   
            type: 'POST',
            data: {
                action: 'delete_user',
                user_id: user_id
            },
            dataType: 'json',
            success: function (response) {
              if (response.status==='success'){

                 Swal.fire({
        icon: 'success',
        title: 'success',
        text: response.message})
                .then(() => location.reload());
              } else if(response.status!=='success'){
                
                 Swal.fire({
        icon: 'error',
        title: 'error',
        text: response.message})
              }
            },
            error: function (xhr) {
                Swal.fire('error', xhr.responseJSON?.message||'Something went wrong!', 'error');
            }
        });

    });
});

});
