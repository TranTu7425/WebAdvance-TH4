// Bổ sung xử lý menu mobile
$(document).ready(function() {
    // Chỉ thêm class active khi menu chưa được xử lý bởi theme.js
    $('.mobile-nav-activator').on('click', function(e) {
        if(!document.body.classList.contains('mobile-menu-opened')) {
            e.preventDefault();
            $('.header-mobile__navigation').addClass('active');
        }
    });
    
    $('.btn-close-lg').on('click', function(e) {
        if(!document.body.classList.contains('mobile-menu-opened')) {
            e.preventDefault();
            $('.header-mobile__navigation').removeClass('active');
        }
    });
}); 