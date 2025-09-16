(function( $ ) {
	'use strict';
	$(document).ready(function () {
		let currentPage = 1;

		function fetchBooks(reset = false) {
			let author = $('#filter-author').val();
			let price = $('#filter-price').val();
			let order = $('#filter-order').val();

			$.ajax({
				url: csBookLoader.rest_url,
				method: 'GET',
				data: {
					author_letter: author,
					price_filter: price,
					order: order,
					page: currentPage
				},
				beforeSend: function (xhr) {
					$('#cs-load-more-btn').prop('disabled', true);
					xhr.setRequestHeader('X-WP-Nonce', csBookLoader.nonce);
				},
				success: function (response) {
					if (reset) {
						// phpcs:ignore WordPressVIPMinimum.JS.HTMLExecutingFunctions.html
						$('.books-list').html(response.html);
					} else {
						// phpcs:ignore WordPressVIPMinimum.JS.HTMLExecutingFunctions.append
						$('.books-list').append(response.html);
					}

					if (response.pagination.current_page < response.pagination.total_pages) {
						$('#cs-load-more-btn').show().prop('disabled', false);
					} else {
						$('#cs-load-more-btn').hide();
					}
				},
				error: function () {
					alert('Error fetching books.');
				}
			});
		}

		// Filters → reset
		$('#filter-author, #filter-price, #filter-order').on('change', function () {
			currentPage = 1;
			fetchBooks(true);
		});

		// Load More
		$('#cs-load-more-btn').on('click', function () {
			currentPage++;
			fetchBooks(false);
		});
	});

})( jQuery );


