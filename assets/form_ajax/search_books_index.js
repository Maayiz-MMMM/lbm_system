$(document).on('keyup change', '#search_books, #search_type, #filter_category', function () {

    let inputVal = $('#search_books').val().trim();
    let searchBy = $('#search_type').val();
    let category = $('#filter_category').val();
    let url      = $('#search_books').data('url');

    if (!inputVal && !category) {
        $('#all_books_table').show();
        $('#search_result').hide().html('');
        return;
    }

    $('#all_books_table').hide();
    $('#search_result').show().html('<p class="text-center">Loading...</p>');

    $.ajax({
        url: url,
        
        type: 'POST',
        dataType: 'json',
       data: {
         action: 'search_books_landing',
    inputVal: inputVal,   
    searchBy: searchBy,
    category: category
},
        success: function(res) {
            let html = '';

            if (res.status === 'success' && res.data && res.data.length > 0) {
                res.data.forEach(book => {
                    html += `
                        <div class="col-md-6 col-lg-4">
                            <div class="service-item book-card">
                                <div class="service-img book-img">
                                    <img 
                                        src="${book.cover_image ? baseAssets + '/' + book.cover_image : defaultCover}" 
                                        alt="${book.title}">
                                    <span class="book-status ${book.available_qty > 0 ? 'bg-success' : 'bg-danger'}">
                                        ${book.available_qty > 0 ? 'Available' : 'Out of Stock'}
                                    </span>
                                </div>

                                <div class="rounded-bottom p-4 bg-white">
                                    <h5 class="fw-bold">${book.title}</h5>
                                    <p class="mb-1"><strong>ISBN:</strong> ${book.isbn}</p>
                                    <p class="mb-1"><strong>Author:</strong> ${book.author}</p>
                                    <p class="mb-1"><strong>Category:</strong> ${book.category_name}</p>
                                    <p class="mb-0"><strong>Qty:</strong> ${book.available_qty}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                html = `
                    <div class="col-12">
                        <div class="bg-danger text-white text-center p-3 rounded">
                            No results found
                        </div>
                    </div>
                `;
            }

            $('#search_result').html(html);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            $('#search_result').html('<div class="col-12 text-danger text-center">Server error</div>');
        }
    });
});
