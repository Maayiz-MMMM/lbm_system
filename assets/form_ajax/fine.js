

$(document).ready(function () {
    $('.pay_amount').on('click', function () {
        //    alert(' clicked');
        var btn = $(this);
        var borrow_id = $(this).data('borrow-id');
        var fine_id = $(this).data('fine-id');
        var fine_member = $(this).closest('tr').find('.fine_member').text();
        var fine_amount = $(this).closest('tr').find('.fine_amount').text();
        var fine_isbn = $(this).closest('tr').find('.fine_isbn').text();


        //  alert(borrow_id);
        if (!borrow_id || !fine_id) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Fields',
                text: 'details not found!'
            });
            btn.prop('disabled', false);
            btn.text('Pay');
            return;


        }

        if (fine_amount <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: 'no fine to pay!'
            });
            btn.prop('disabled', false);
            btn.text('Pay');
            return;
        }


        $('#fine_amount_form .pay_borrow_id').val(borrow_id);
        $('#fine_amount_form .pay_fine_id').val(fine_id);
        $('.member_name').val(fine_member);
        $('.book_isbn').val(fine_isbn);
        $('.fine_amount').val(fine_amount);
        $('.member_name').val(fine_member);
        //         $('.pay_amount_modal #book_isbn').text(fine_book_isbn);

        if (!fine_member || !fine_isbn || !fine_amount) {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: 'Member details not found!'
            });

            return;
        }

        $('.pay_amount_modal').modal('show');


    })

    $('.payment_submit_btn').on('click', function () {
        var formData = $('#fine_amount_form')[0];
        var data = new FormData(formData);
        var btn = $(this);
        btn.prop('disabled', true);
        btn.text('payment Processing...');
        var url = $('#fine_amount_form').attr('action');
        data.append('action', 'pay_fine');
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
                        title: 'error',
                        text: response.message
                    });
                } else if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: response.message
                    }).then(() => {
                        setTimeout(function () {
                            $('.pay_amount').prop('disabled', true);
                            $('.pay_amount').text('paid success');
                            $('.pay_amount_modal').modal('hide');
                            location.reload();
                            $('.pay_amount').prop('disabled', true);
                            $('.pay_amount').text('paid success');
                        }, 500);
                    });
                }

            },
            error: function (res) {
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text: res.message
                })
                btn.prop('disabled', false);
                btn.text('Submit Payment');
            }
        });
    })
    $('.checked_check').on('change', function () {
        if (!$('.checked_check').prop('checked')) {
            $('.fine_submit_btn').prop('disabled', true);
            return;
        }
        else {
            $('.fine_submit_btn').prop('disabled', false);
        }
        if ($('.checked_check').prop('checked')) {
        }
    });



})