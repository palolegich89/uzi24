'use strict';

window.addEventListener('DOMContentLoaded', function () {
    var selectElements = Array.from(document.querySelectorAll('.styled-select'));
    selectElements.forEach(function (one) {
        new jtSelect(one, {
            searchField: false
        });
    });

    $('.faq__question-title a').on('click', function (e) {
        e.preventDefault();
        var _parent = $(this).closest('.faq__question');
        if (_parent.hasClass('open')) {
            _parent.removeClass('open');
        } else {
            $('.faq__question').removeClass('open');
            _parent.addClass('open');
        }
    });

    $('[scroll-to]').on('click', function (e) {
        e.preventDefault();
        var _block = $(this).attr('scroll-to');
        $('html, body').animate({ scrollTop: $(_block).offset().top - 25 }, 1500);
    });

    $('.metro-stations__columns').isotope({
        itemSelector: '.metro-stations__one',
        percentPosition: true,
        masonry: {
            // use outer width of grid-sizer for columnWidth
            columnWidth: '.metro-stations__one'
        }
    });
});