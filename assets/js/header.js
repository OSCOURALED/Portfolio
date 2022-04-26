$(function() {
    var scrollHeader = 505;
    $(window).scroll(function() {
        var scroll = getCurrentScroll();
        if (scroll >= scrollHeader) {
            $('.header').addClass('scrolled');
        } else {
            $('.header').removeClass('scrolled');
        }
    });

    function getCurrentScroll() {
        return window.pageYOffset || document.documentElement.scrollTop;
    }
});