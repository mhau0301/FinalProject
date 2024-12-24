import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function() {
    // Khi form tìm kiếm được gửi, thực hiện AJAX
    $('#search-form').on('submit', function(event) {
        event.preventDefault(); // Ngừng việc gửi form mặc định

        let query = $('#search-query').val(); // Lấy giá trị tìm kiếm

        // Gửi yêu cầu AJAX
        $.ajax({
            url: '/search', // URL để tìm kiếm sản phẩm
            type: 'GET',
            data: {
                query: query
            },
            success: function(response) {
                // Hiển thị kết quả tìm kiếm ngay dưới thanh header
                $('#search-results').html(response);
            }
        });
    });
});
