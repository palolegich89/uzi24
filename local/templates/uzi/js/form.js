$(document).ready(function () {

    //
    // //todo WTF????? -> Speciality_four_doctors
    // var clinics = $('.clinics');
    // clinics.each(function (i, clinic) {
    //     var biggest = 0;
    //     $(clinic).find('.doctor-head').each(function (i, head) {
    //         var height = $(head).height();
    //         if (height > biggest) {
    //             biggest = height;
    //         }
    //     });
    //     $(clinic).find('.doctor-head').each(function (i, head) {
    //         $(head).css('height', biggest);
    //     })
    // });
    //
    // $('.main-menu').click(function (e) {
    //     e.stopPropagation();
    // });
    // $('html').on('click', '.menu-visible', function () {
    //     $('.menu-btn').click();
    // })
    //
    // try {
    //     $('.photo-clinic .crl1').slick({
    //         infinite: false,
    //         lazyLoad: 'ondemand',
    //         speed: 500,
    //         slidesToShow: 1,
    //         mobileFirst: true,
    //         variableWidth: true,
    //         responsive: [
    //             {
    //                 breakpoint: 0,
    //                 settings: {
    //                     slidesToShow: 1
    //                 }
    //             },
    //             {
    //                 breakpoint: 1120,
    //                 settings: {
    //                     slidesToShow: 3
    //                 }
    //             }
    //         ]
    //     });
    // } catch (e) {
    // }

    // $('.photo-clinic .crl1 a').fancybox({
    //     'beforeClose': function (el, q, w) {
    //
    //         var sl = $('.photo-clinic .crl1');
    //         var slidesCount = sl.slick('getSlick').slideCount;
    //
    //         var index = el.currIndex;
    //
    //         if (index > (slidesCount - sl.slick('slickGetOption', 'slidesToShow'))) {
    //             index = slidesCount - sl.slick('slickGetOption', 'slidesToShow');
    //         }
    //
    //         sl.slick('slickGoTo', index)
    //     },
    // });

    //tabs
    // $('.tabs li').click(function (e) {
    //     var el = $(this);
    //     if (!el.hasClass('active')) {
    //         $('.tabs .active').removeClass('active');
    //         el.addClass('active');
    //         $('.tab-content > div:visible').hide();
    //         $('.tab-content > div').eq(el.index()).show();
    //     }
    //     return false;
    // });
    //
    //
    // //data-hidden
    // $('[data-hidden]').click(function (e) {
    //     var el_class = $(this).data('hidden');
    //     var el = $('.hidden.' + el_class);
    //     el.slideToggle();
    //     return false;
    // });
    //
    // //todo refactor
    // $('[data-unload]').click(function (e) {
    //     if ($(this).data('open') === false) {
    //         $(this).data('open', true);
    //         var el = $("." + $(this).data("unload")),
    //             curHeight = el.height(),
    //             autoHeight = el.css('height', 'auto').height();
    //         $(this).data('height', curHeight);
    //         $(this).find('span').html($(this).data('hidetext'));
    //         el.height(curHeight).animate({height: autoHeight}, 800);
    //     } else {
    //         $(this).data('open', false);
    //         var el = $("." + $(this).data("unload")),
    //             curHeight = el.height(),
    //             autoHeight = $(this).data('height');
    //         $(this).find('span').html($(this).data('opentext'));
    //         el.height(curHeight).animate({height: autoHeight}, 800);
    //     }
    //     return false;
    // });
    //
    // //data-hblock
    // $('a[data-hblock]').click(function (e) {
    //     var el = $(this);
    //     var el_turn = el.data('turn');
    //     var el_expand = el.data('expand');
    //     var data = el.data('hblock');
    //     if (!$('.hidden:visible').data('hblock', data).length) {
    //         $('.hidden').data('hblock', data).slideDown();
    //         el.text(el_turn);
    //     } else {
    //         $('.hidden').data('hblock', data).slideUp();
    //         el.text(el_expand);
    //     }
    //     return false;
    // });

    //
    // $('.clinic-address > .metro').click(function (e) {
    //     var el = $(this);
    //     if (!$('.drop-down:visible', el).length) {
    //         $('.drop-down', el).fadeIn();
    //     }
    //     return false;
    // });
    // $('.clinic-address > .metro').hover(function (e) {
    // }, function () {
    //     var el = $(this);
    //     $('.drop-down:visible', el).fadeOut();
    // });

    $(document).on('click', '.js-submit-btn-record', function (e) {
        e.preventDefault(e);
        var form = $(this).parent('.js-form');
        var url = '';
        if ($(this).data('request')) {
            url = $(this).data('request');
        }

        var success;
        if (url == '') {
            success = function (data) {
                popupInfo('Ваш заявка принята');
            };
        } else {
            success = function (data) {
                data = JSON.parse(data);
                $(".pp-error").html("");
                if(data.status == "fail"){
                    $(".pp-error").html(data.error_message);
                }
                else if (typeof data.action != "undefined") {
                    if (data.action == "preOrder") {
                        //открыть поле для смс
                        $(".sms-validate").css("display", "block");
                        //заполнить поле requestId
                        $("[name='requestId']").val(data.requestId);
                    }
                    if (data.action == "smsNotValid") {
                        //открыть поле для смс
                        $(".sms-validate").val("");
                        $(".sms-validate-error").css("display", "block");
                        //заполнить поле requestId
                        //$("[name='requestId']").val( data.requestId );

                    }
                    if (data.action == "orderDone") {
                        Fancybox.close();
                        clearForm(form);
                        Fancybox.show([{
                            dragToClose: false,
                            src: "#popup-thanks",
                            type: "inline",
                        }]);
                    }
                } else {
                    Fancybox.show([{
                        dragToClose: false,
                        src: "#error-popup",
                        type: "inline",
                    }]);
                }
            }
        }

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function (data) {
                success(data);
            },
        });
    })


    $('.js-submit-btn').on('click', function (e) {
        e.preventDefault(e);
        var form = $(this).parent('.js-form');
        var url = '';
        if ($(this).data('request')) {
            url = $(this).data('request');
        }

        var success;
        if (url == '') {
            success = function (data) {
                popupInfo('Ваш отзыв принят к рассмотрению');
            };
        } else {
            success = function (data) {
                data = JSON.parse(data);
                popupInfo(data.message);
            }
        }

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function (data) {
                success(data);
            },
        });
    })

    $('body').on('input', '.js-form input', function (e) {

        var form = $(this).parents('.js-form');

        var name = form.find('input[name=name]').val().length;
        var phone = form.find('input[name=phone]').val().length;

        if (name && phone) {
            form.find('.js-submit-btn-record').removeClass('btn-disabled');
            form.find('.js-submit-btn-record').attr('disabled', false);
        } else {
            form.find('.js-submit-btn-record').addClass('btn-disabled');
            form.find('.js-submit-btn-record').attr('disabled', true);
        }
    })

    // $('.js-form .rate-block li').on('click', function () {
    //     $(this).removeClass('empty');
    //     $(this).prevAll('li').removeClass('empty');
    //     $(this).nextAll('li').addClass('empty');
    //
    //     $(this).siblings('input').val($(this).prevAll('li').length + 1);
    // });

    // $('.js-spoiler-toggle').on('click', function (e) {
    //     e.preventDefault();
    //     var target = $(this).data('target');
    //     var self = this;
    //
    //     var data = {};
    //     var url = '/ajax/getClinicReviews/';
    //
    //     data['offset'] = $(this).data('offset');
    //
    //     if ($(this).data('clinic')) {
    //         data['clinicId'] = $(this).data('clinic');
    //
    //     }
    //
    //     if ($(this).data('doctor')) {
    //         data['doctorId'] = $(this).data('doctor');
    //         url = '/ajax/getDoctorReviews/'
    //     }
    //
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         data: data,
    //         success: function (data) {
    //             $(target).append(data);
    //
    //             $(self).data('offset', $(self).data('offset') + 10);
    //             if ($(self).data('clinicscount') - $(self).data('offset') <= 0) {
    //                 $(self).hide()
    //             }
    //         },
    //     });
    // });
    //
    // $('.js-doctors-spoiler-toggle').on('click', function (e) {
    //     e.preventDefault();
    //     var target = $(this).data('target');
    //     var self = this;
    //     $.ajax({
    //         type: "POST",
    //         url: '/ajax/getClinicDoctors/',
    //         data: {
    //             offset: $(this).data('offset'),
    //             clinicId: $(this).data('clinic'),
    //         },
    //         success: function (data) {
    //             $(target).append(data);
    //             $(self).hide()
    //         },
    //     });
    // });
    //
    // $('.js-price-spoiler-toggle').on('click', function (e) {
    //     e.preventDefault();
    //     var target = $(this).data('target');
    //     var self = this;
    //     $.ajax({
    //         type: "POST",
    //         url: '/ajax/getClinicPrices/',
    //         data: {
    //             clinicId: $(this).data('clinic'),
    //         },
    //         success: function (data) {
    //             $(target).html(data);
    //         },
    //     });
    // });

    function checkTabAnchor() {
        var hash = location.hash;

        var match = hash.match(/#tab-/);


        if (match && $(hash).length) {
            $(hash).click();
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 500);
        }
    }

    //slots
    $(document).on('click', '.slot-trigger', function (e) {
        e.preventDefault(e);
        $this = $(this);
        url = "/ajax/doctor_slots.php";
        var doctor = $(this).data("doctor");
        var clinic = $(this).data("clinic");

        $(".slots").html("");
        $(".slots").css("height", "0px");
        if (typeof window.owl != "undefined") {
            window.owl.remove();
        }
        var slotsBlockId = "slots_" + doctor;
        /*if(typeof BX != "undefined")
            {
                BX.showWait( slotsBlockId );
            }*/
        $("#" + slotsBlockId).addClass("slot-loader");
        $.ajax({
            type: "POST",
            url: url,
            data: {
                "doctor": doctor,
                "clinic": clinic,
            },

            success: function (data) {
                /*if(typeof BX != "undefined")
                    {
                        BX.closeWait( slotsBlockId );
                    }*/
                $("#" + slotsBlockId).removeClass("slot-loader");

                $this.remove();
                if (data != "noshow") {
                    $(".slots").html(data);
                    $(".slots").css("height", "270px");
                    $(".whiteshadow").css("height", "50px");
                    setTimeout(function () {
                        window.owl = $('.owl-carousel');
                        window.owl.owlCarousel({
                            margin: 10,
                            loop: false,
                            nav: true,
                            navText: [
                                '<div class="carousel__prev"><a href="javascript:void(0);" class="carousel__toleft"><i aria-hidden="true" class="fa fa-chevron-left fa-2x"></i></a></div>',
                                '<div class="carousel__next"><a href="javascript:void(0);" class="carousel__toright"><i aria-hidden="true" class="fa fa-chevron-right fa-2x"></i></a></div>'
                            ],
                            responsive: {
                                0: {items: 1},
                                350: {items: 2},
                                700: {items: 3},
                                1050: {items: 4}
                            }
                        })
                    }, 100);
                } else {
                    $(".slots").css("min-height", "0px");
                    $(".whiteshadow").css("height", "0px");
                }
            },
        });

    });

    $(document).on('click', '.slot', function (e) {

        e.preventDefault(e);
        $this = $(this);
        var date = $(this).data("date");
        var datetime = $(this).data("format-date")//date;
        var slotId = $(this).data("id");
        var doctor = $(this).data("doctor");
        var clinic = $(this).data("clinic");
        var slotsBlockId = "slots_" + doctor;

        $(".slots").css("min-height", "32px");
        $("#" + slotsBlockId).addClass("slot-loader");

        //check slot function
        url = "/ajax/check_doctor_slot.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                "doctor": doctor,
                "clinic": clinic,
                "slot": slotId
            },

            success: function (data) {
                $("#" + slotsBlockId).removeClass("slot-loader");
                window.owl.remove();
                $(".slots").html("");
                $(".slots").css("height", "0px");
                $(".slots").css("min-height", "0px");
                $(".date-time-text").css("display", "block");

                if (data == "ok") {
                    $("[name='slot']").val(slotId);
                    //$('.slot').each(function() {
                    //$(this).removeClass("selected");
                    //});
                    $(".whiteshadow").css("height", "0px");
                    setTimeout(function () {
                        //$this.addClass("selected");
                        var admission = datetime;
                        datetime = datetime + " &nbsp;<a href='javascript://' class='slot-trigger' data-doctor='" + doctor + "' data-clinic='" + clinic + "' >Выбрать другое</a>";
                        $(".date-time-text span").html(datetime);
                        $("[name='admission']").val(admission);
                    }, 50);
                } else {
                    $(".date-time-text span").html("<span class='red'>" + datetime + "</span><br>К сожалению, в выбранное время ктото уже записался, попробуйте выбрать другое.");
                    $('.slot-trigger').first().click();
                }
            },
        });
    });

    checkTabAnchor();


    // $('.doctor-card--appointment').each(function (i, app) {
    //     $.ajax({
    //         type: "POST",
    //         url: '/ajax/get_nearest_appointment/',
    //         data: {
    //             "doctor": $(app).data('doctor'),
    //             "clinic": $(app).data('clinic')
    //         },
    //         success: function (data) {
    //             if (data.length > 0) {
    //                 $(app).find('.doctor-card--date').html(data);
    //                 $(app).removeClass('hidden');
    //             }
    //         }
    //     });
    // });
    //
    // $('a.spoiler-trigger').on('click', function (e) {
    //     e.preventDefault();
    //     var target = $($(this).data('target'));
    //     target.show();
    //     $(this).remove();
    // })

});

function clearForm($form)
{
    $form.find(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    $form.find(':checkbox, :radio').prop('checked', false);
}

/*
$(document).on('click', '.js-submit-btn', function (e) {
    e.preventDefault(e);
    var form = $(this).parent('.js-form');
    var url = '';
    if ($(this).data('request')) {
        url = $(this).data('request');
    }

    var success;
    if (url == '') {
        success = function (data) {
            popupInfo('Ваш отзыв принят к рассмотрению');
        };
    } else {
        success = function (data) {
            data = JSON.parse(data);

            if(typeof data.action !="undefined")
            {
                if(data.action == "preOrder")
                {
                    //открыть поле для смс
                    $(".sms-validate").css("display","block");
                    //заполнить поле requestId
                    $("[name='requestId']").val( data.requestId );

                }
                if(data.action == "smsNotValid")
                {
                    //открыть поле для смс
                    $(".sms-validate").val("");
                    $(".sms-validate-error").css("display","block");
                    //заполнить поле requestId
                    //$("[name='requestId']").val( data.requestId );

                }
                if(data.action == "orderDone"){
                    popupInfo(data.message);
                }
            }
            else{
                popupInfo(data.message);
            }
        }
    }

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function (data) {
            success(data);
        },
    });
})

$('.js-submit-btn').on('click', function (e) {
    e.preventDefault(e);
    var form = $(this).parent('.js-form');
    var url = '';
    if ($(this).data('request')) {
        url = $(this).data('request');
    }

    var success;
    if (url == '') {
        success = function (data) {
            popupInfo('Ваш отзыв принят к рассмотрению');
        };
    } else {
        success = function (data) {
            data = JSON.parse(data);
            popupInfo(data.message);
        }
    }

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function (data) {
            success(data);
        },
    });
})

$('body').on('input', '.js-form input', function (e) {

    var form = $(this).parents('.js-form');

    var name = form.find('input[name=name]').val().length;
    var phone = form.find('input[name=phone]').val().length;

    if (name && phone) {
        form.find('.js-submit-btn').removeClass('btn-disabled');
        form.find('.js-submit-btn').attr('disabled', false);
    } else {
        form.find('.js-submit-btn').addClass('btn-disabled');
        form.find('.js-submit-btn').attr('disabled', true);
    }
})

$('.js-form .rate-block li').on('click', function () {
    $(this).removeClass('empty');
    $(this).prevAll('li').removeClass('empty');
    $(this).nextAll('li').addClass('empty');

    $(this).siblings('input').val($(this).prevAll('li').length + 1);
});


function popupInfo(message) {
    message = message || null;
    $('.popup:visible').fadeOut(200);
    var popup = $('.popup.pp-info');
    popup.appendTo("body");
    if (message) {
        popup.find('.pp-title').html(message);
    }
    var top = $(window).scrollTop() - 30;
    if ($(window).width() <= popup.outerWidth()) {
        popup.css({"width": $(window).width() - 50, "height": $(window).height() - 20});
    }
    popup.css({
        left: ($(window).width() - popup.outerWidth()) / 2,
        top: $(window).scrollTop() + 30
    });
    popup.fadeIn(200);
}*/

/*!
 * $.fn.apiModal
 */
/*
(function ($, undefined ) {

    "use strict"; // Hide scope, no $ conflict

    var defaults = {
        id: '',
        header: '',
        footer: '',
    };

    var methods = {
        init: function (params) {

            var $html = $('html');
            var options = $.extend({}, defaults, options, params);

            if (!this.data('apiModal')) {
                this.data('apiModal', options);

                if (!$html.hasClass('api-modal-init'))
                    $html.addClass('api-modal-init');

                $('window').on('resize', function () {
                    $.fn.apiModal('resize', options);
                });

                $(document).on('click', '.api_modal,.api_modal_close', function (e) {
                    e.preventDefault();

                    $('.api_modal .api_modal_dialog').css({
                        'transform': 'translateY(-200px)',
                        '-webkit-transform': 'translateY(-200px)'
                    });
                    $('.api_modal').animate({opacity: 0}, 250, function () {
                        $(this).hide().removeClass('api_modal_open');
                        $html.removeClass('api_modal_active');
                    });
                });

                $(document).on('click', '.api_modal .api_modal_dialog', function (e) {
                    //e.preventDefault();
                    e.stopPropagation();
                });
            }

            return this;
        },
        show: function (options) {
            $('html').addClass('api_modal_active');
            if (options.header) {
                $(options.id + ' .api_modal_header').html(options.header);
            }
            $(options.id + ' .api_modal_dialog').removeAttr('style');
            $(options.id).show().animate({opacity: 1}, 1, function () {
                $(this).addClass('api_modal_open');
                $.fn.apiModal('resize', options);
            });
        },
        resize: function (options) {

            var dialog = options.id + ' .api_modal_dialog';

            if (options.width) {
                $(dialog).width(options.width);
            }

            if ($(options.id + '.api_modal_open').length) {
                var dh = $(dialog).outerHeight(),
                    pad = parseInt($(dialog).css('margin-top'), 10) + parseInt($(dialog).css('margin-bottom'), 10);

                if ((dh + pad) < window.innerHeight) {
                    $(dialog).animate({top: (window.innerHeight - (dh + pad)) / 2}, 100);
                } else {
                    $(dialog).animate({top: ''}, 100);
                }
            }
        },
        hide: function (options) {
            $(options.id).hide().removeClass('api_modal_open');
            $('html').removeClass('api_modal_active');
        }
    };

    $.fn.apiModal = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Error! Method "' + method + '" not found in plugin $.fn.apiModal');
        }
    };

})(jQuery);*/

/*function showRecordForm() {
    $('body').addClass('show-record-form');
    document.getElementsByTagName("body")[0].style.overflow = 'hidden';
}

function hideForm() {
    $('body').removeClass('show-record-form');
    document.getElementsByTagName("body")[0].style.overflow = 'scroll';
}*/
$('.js-record').on('click', function (e) {

    var clinicId = $(this).data('clinic');
    console.log(clinicId);
    var hiddenInput = $('.js-form input[name="clinic"]');

    hiddenInput.val(clinicId);

});