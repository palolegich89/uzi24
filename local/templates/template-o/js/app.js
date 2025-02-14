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

    /*$('.metro-stations__columns').isotope({
        itemSelector: '.metro-stations__one',
        percentPosition: true,
        masonry: {
            // use outer width of grid-sizer for columnWidth
            columnWidth: '.metro-stations__one'
        }
    });*/
});
$(document).ready(function() {
    var mapInstance = null;
    var showingMenu = false;
    $('a.show_map').on('click', function(e) {
        e.preventDefault();
        $('.back-shadow').fadeIn(200, function() {
            $('#map-container').fadeIn(200, function() {
                if (mapInstance == null) {
                    ymaps.ready(init);
                    mapInstance = true;
                }
            });
        });
    });
    $('a.map-close').on('click', function(e) {
        e.preventDefault();
        $('.back-shadow, #map-container').fadeOut();
    });
    $('li.has_sub_menu > a').on('click', function(e) {
        var _windowWidth = $(window).width();
        if (_windowWidth > 767) {
            e.preventDefault();
            $('li.has_sub_menu').removeClass('active');
            $('.header__nav__hided-menu').hide();
            var _parent = $(this).parent('li');
            $('.header__nav').addClass('show-submenu');
            _parent.addClass('active');
            $('.header__nav__hided-menu', _parent).show();
            $('.back-shadow').show();
        }
    });
    $(document).on('click', function(e) {
        var _windowWidth = $(window).width();
        if (_windowWidth > 767) {
            if ($(e.target).closest('.header__nav').length == 0 && $('.header__nav').hasClass('show-submenu')) {
                $('.header__nav').removeClass('show-submenu');
                $('li.has_sub_menu').removeClass('active');
                $('.back-shadow').hide();
                $('.header__nav__hided-menu').hide();
            }
        }
    });
    $(window).on('scroll', function() {
        var _scroll = $(window).scrollTop(),
            _headerHeight = parseInt($('.header').css('height'));
        if (_scroll > _headerHeight + 80) {
            $('.header').hide();
            $('.float-header').show();
            $('body').css({
                'padding-top': _headerHeight
            });
        } else {
            $('.header').show();
            $('.float-header').hide();
            $('body').css({
                'padding-top': '0px'
            });
        }
    });
    $('a.show_mobile_menu').on('click', function(e) {
        e.preventDefault();
        if ($(this).hasClass('click')) {
            $('.header__nav').fadeOut(200);
            $(this).removeClass('click');
        } else {
            $('.header__nav').fadeIn(200);
            $(this).addClass('click');
        }
    });
    $(document).on('click', function(e) {
        if ($(e.target).closest('.header__nav').length == 0 && $('a.show_mobile_menu').hasClass('click') && $(e.target).closest('a.show_mobile_menu').length == 0) {
            $('.header__nav').fadeOut();
            $('a.show_mobile_menu').removeClass('click');
        }
    });
});