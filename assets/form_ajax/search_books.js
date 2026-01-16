$(document).on('keyup', '#search_books', function () {

    let inputVal = $(this).val();
    if(inputVal) {
        $('#all_books_table').hide();
         $('#search_result').show();
    } else {
        $('#all_books_table').show();
        $('#search_result').hide();
    }
    let url = $(this).data('url');
    var baseUrl = $(this).data('baseurl');

    if (inputVal !== '') {
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {  action:'search_books_member',
                inputVal,
                
             },
            success: function (res) {

                if (res.status === 'success') {
                    let html = '';

                    if (res.data.length > 0) {
                        res.data.forEach(book => {
                            html += `
                                <tr>
                                    <td>${book.isbn}</td>
                                    <td>${book.title}</td>
                                    <td>${book.author}</td>
                                    <td>${book.category_name ?? '-'}</td>
                                   <td>
                ${book.cover_image 
                    ? `<img src="${baseUrl}assets/uploads/books/${book.cover_image}" alt="${book.title}" class="table-book-img" width="80" id="uploadedAvatar" />` 
                    : 'No Image'}
            </td>
                                    <td>${book.available_qty}</td>
                                </tr>
                            `;
                        });
                    } else {
                        html = `<tr><td  style="text-align:center;"  colspan="6"> No results found.</td> </tr>`;
                    }

                    $('#search_result').html(html).show();
                }
            }
        });
    } else {
        $('#search_result').hide().html('');
    }
});