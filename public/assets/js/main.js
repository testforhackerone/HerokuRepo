/*------------- preloader js --------------*/
$(window).on('load', function() {
    $('.loader-wraper').fadeOut(100);
});

$(document).ready(function() {
    "use strict";

    /*------------ Start site menu  ------------*/

    // Start sticky header
    $(window).on('scroll', function() {
        if ($(window).scrollTop() >= 150) {
            $('#sticky-header').addClass('sticky-menu');
        } else {
            $('#sticky-header').removeClass('sticky-menu');
        }
    });

    $('#category-table').DataTable({
        'responsive': true,
        'details':true
    });
    $('#qz-question-table').DataTable({
        'responsive': true,
        'details':true
    });

    $('.sidebarToggler').on('click', function(){
        $('.qz-sidebar').toggleClass('sidebarToggle')
    })

    $('.qz-sidebar').scrollbar();

    // $(document).ready(function () {
    //     $("#notification_box").fadeOut(4000);
    // });

    setTimeout(function () {
        $(".myalert").fadeOut()
    }, 4000);

    /* Add here all your JS customizations */
    $('.number-only').keypress(function (e) {
        var regex = /^[+0-9+.\b]+$/;
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
    $('.no-regx').keypress(function (e) {
        var regex = /^[a-zA-Z+0-9+\b]+$/;
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });


});