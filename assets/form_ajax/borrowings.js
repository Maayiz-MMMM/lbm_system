

// var create_user = document.getElementById('create_user');
// create_user.addEventListener('click', function (){
    // alert('create_user')
// });


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
    var namePattern = /^[A-Za-z\s]+$/;

    if (!namePattern.test(input.value.trim())) {
        Swal.fire('Invalid Input', 'Only letters are allowed!', 'error');
        input.classList.add('is-invalid');
        return;
    }

    input.classList.remove('is-invalid');
    return true;
}


  $('#create_borrowing_btn').on('click', function (){

        var formData = $('#create_borrowing_form')[0];
        var btn = $(this);
       
        var memberValidate = validateField(formData.member);
     var bookValidate = validateField(formData.book);
     var issue_dateValidate = validateField(formData.issue_date);
     var statusValidate = validateField(formData.status);
     var qtyValidate = validateField(formData.qty);

   if (!memberValidate ||
        !bookValidate||
        ! issue_dateValidate ||
        !statusValidate||
        !qtyValidate) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'Please fill all the details correctly!'
        });
    }

    
    if (!formData.checkValidity()) {
    formData.classList.add('was-validated');
return;
}
        var data = new FormData(formData);
        
        btn.prop('disabled', true);
        btn.text('Creating...');



    var url = $('#create_borrowing_form').attr('action');
data.append('action', 'create_borrowing');
        $.ajax({        
            url: url,
            type: 'POST',
            data: data,
           processData: false,
           contentType: false,
              dataType: 'json',
            success: function (response) {

    if (response.status !== 'success') {
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: response.message
        });
        btn.prop('disabled', false);
        btn.text('create');
        return;
    }

    if (response.status === 'success') {
       Swal.fire({
            icon: 'success',
            title: 'success',
            text: response.message
        }).then(()=>{
            setTimeout(function (){
        $('.create_borrowing_modal').modal('hide');
        location.reload(); },500);});
    }
}

,
            error: function (response) {
               Swal.fire({
            icon: 'error',
            title: 'error',
            text: response.message||'somthing went wrong'
        });; btn.prop('disabled', false);
        btn.text('create');
        return;
            }
        });




});
 
$('.return_date_submit').on('click', function (){
          
     $('.add_return_date_modal').modal('show');
        var borrow_id = $(this).data('id');
        $('#borrow_id').val(borrow_id);
});
    $('#create_return_date_btn').on('click', function (){
         var btn = $(this);
        var formData = $('#create_return_date_form')[0];
        var return_date_Validate = validateField(formData.return_date);
     var statusValidate = validateField(formData.status);
   

   if (!return_date_Validate ||
        !statusValidate) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'Please fill all the details correctly!'
        });
        
    }
   
    if (!formData.checkValidity()) {
    formData.classList.add('was-validated');
return;
}


        var data = new FormData(formData);
      
        var borrow_id  = $('#borrow_id').val();
        data.append('borrow_id', borrow_id);
      
        btn.prop('disabled', true);
        btn.text('Creating...');



    var url = $('#create_return_date_form').attr('action');
data.append('action', 'create_return_date');
        $.ajax({        
            url: url,
            type: 'POST',
            data: data,
           processData: false,
           contentType: false,
              dataType: 'json',
            success: function (response) {

                if(response.status !== 'success'){
                    Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: response.message
         }); 

         btn.prop('disabled', false);
        btn.text('Create');
        return;
                } else if (response.status==='success'){

                Swal.fire({
            icon: 'success',
            title: 'success',
            text: response.message
        }).then(()=>{


                setTimeout(function() {
                
                    $('.add_return_date_modal').modal('hide');
                location.reload();
                }, 500);});}
                
            },
            error: function (response) {
                   
                Swal.fire({
            icon: 'error',
            title: 'error',
            text: response.message||'somthing went wrong'
        });
        btn.prop('disabled', false);
        btn.text('Create');
        return;
            }
        }); 




});

$(document).on('click', '.edit_borrowing', function (e) {
    e.preventDefault();
   
    var borrow_id = $(this).data('id');

    var url = $('#create_borrowing_form').attr('action');

    $.ajax({
        url: url,
        type: 'POST',
        data: { action: 'get_borrowing', borrow_id: borrow_id },
        dataType: 'json',
        success: function (response) {
              
            if (response.status === 'success') {
                 $('#borrow_id_edit').val(response.data.borrow_id);
            $('#edit_member').val(response.data.member_id); 
            $('#edit_book').val(response.data.book_id);     
            $('#edit_issue_date').val(response.data.issue_date);
            $('#status_edit').val(response.data.status);
            $('#edit_qty').val(response.data.qty);
                $('.edit_borrowing_modal').modal('show');
               
            }
        },
        error: function (response) {
             
                Swal.fire({
            icon: 'error',
            title: 'error',
            text: response.message||'somthing went wrong'
        });;
        }
    });
    });


    $('#edit_borrowing_btn').on('click', function () {
        var formData = $('#edit_borrowing_form')[0];

          var member_Validate = validateField(formData.member_id);
             var book_Validate = validateField(formData.book_id);
             var issue_date_Validate = validateField(formData.issue_date);
             var status_Validate = validateField(formData.status);
             var qty_Validate = validateField(formData.qty);

              if (!member_Validate ||
         !book_Validate||
         !issue_date_Validate||
         !status_Validate||
        !qty_Validate) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'Please fill all the details correctly!'
        });
       
        return;
    }

    if (!formData.checkValidity()) {
    formData.classList.add('was-validated');
return;
}

        
        var data = new FormData(formData);
        var btn = $(this);

        btn.prop('disabled', true);
        btn.text('Updating...');
        
        var url = $('#edit_borrowing_form').attr('action');
        data.append('action', 'edit_borrowing');
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {

                if(response.status!=='success'){
                    Swal.fire({
            icon: 'error',
            title: 'somthing wrong',
            text: response.message

        }); btn.prop('disabled', false);
        btn.text('Update');
                } else if(response.status==='success'){
                        Swal.fire({
            icon: 'success',
            title: 'success',
            text: response.message}).then(()=>{
                    
                setTimeout(function() {
                    $('.edit_borrowing_modal').modal('hide');
                location.reload();
                }, 500);});
            
        }
                
                
            }
,            error: function (response) {
                  
                Swal.fire({
            icon: 'error',
            title: 'error',
            text: response.message||'somthing went wrong'});
            btn.prop('disabled', false);
        btn.text('Update');
            
       } }); 
    });

    

    $(document).on('click', '.delete_borrowing', function () {

    var borrow_id = $(this).data('id');
 var url = $('#edit_borrowing_form').attr('action');
    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'You will not be able to recover this borrow!',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $.ajax({
            url: url,   
            type: 'POST',
            data: {
                action: 'delete_borrow',
                borrow_id: borrow_id
            },
            dataType: 'json',
            success: function (response) {

              if (response.status==='success'){
                Swal.fire({ icon: 'success',
        title: 'success!',
        text: response.message})
                .then(() => location.reload());

              } else if(response.status!=='success'){
                
                 Swal.fire('error','error ',response.message)
              }
            },
            error: function (xhr) {
                Swal.fire('error', xhr.responseJSON?.message||'Something went wrong!', 'error');
            }
        });

    });
});

   


});