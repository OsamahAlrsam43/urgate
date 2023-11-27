/*under*/

/*end under*/
/*jslint browser: true*/
/*global $, jQuery*/

$(function () {
    "use strict";

    function aspectRatio() {
        "use strict";


        //Add attr
        $('a.card-block > img').attr('data-heqw', '1.9');
        $('.travel-post-gallery img').attr('data-heqw', '1.7');

        // Start Aspect ratio
        $("[data-heqw]").each(function () {
            var xclass = $(this).attr('data-heqw');
            var finalv = Number($(this).innerWidth()) / Number(xclass);
            if (finalv != 0) {
                $(this).css('height', finalv);
            } else {
                setTimeout(function () {
                    aspectRatio();
                }, 5000)
            }
        });
        // End Aspect ratio
    }

    $(document).ready(function () {

        /* ---------------------------------------------------------------------- */
        /*	Mobile Menu
        /* ---------------------------------------------------------------------- */

        $(".open-menu, .mobile-menu-overlay").on('click', function (e) {
            $('.mobile-menu').toggleClass("active");
            return false;
        });
        /* ---------------------------------------------------------------------- */
        /*	Clone form
        /* ---------------------------------------------------------------------- */

        $("#cloneForm").on('click', function (e) {
            $('.visa-inner .custom-form .form-row:first-child').clone().prepend('<a href="#" class="btn btn-danger btn-sm removeForm">\n' + 'Delete Applicant\n' + '</a>').insertBefore(".visa-inner .custom-form .action-btns");

            // Datepicker
            $(".datepicker").each(function (index) {
                $(this).attr('id', 'picker_' + index);
                $(this).removeClass('hasDatepicker');
                $(this).datepicker({
                    dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true
                });
            });


            $('.date-mask').on('focus', function () {
                $(this).mask('00/00/0000', {placeholder: "__/__/____"});
            }).on('change', function () {
                var val = $(this).val();
                var datParts = val.split("/");

                var dateCheck = moment(datParts[1] + "/" + datParts[0] + "/" + datParts[2]);

                if(!dateCheck.isValid()) {
                    console.log(val);
                    alert("Date is invalid, please enter a valid date");
                    $(this).val("")
                }
            });


            return false;
        });

        $('body').on('click', ".removeForm", function (e) {
            e.preventDefault();
            $(this).parent('.form-row').remove();
        });

        /* ---------------------------------------------------------------------- */
        /*	latestOffers
        /* ---------------------------------------------------------------------- */
        //Owl carousel #ourClients
        $('#latestOffers').owlCarousel({
            items: 3,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                900: {
                    items: 2
                },
                1200: {
                    items: 3
                },
                1400: {
                    items: 3
                },
            },
            loop: true,
            center: false,
            dots: true,
            nav: false,
            margin: 20,
            rtl: true,
            autoplay: false,
            autoplayTimeout: 4000,
            dotsContainer: '#latestOffersDots',

        });
        // Go to the next item #ourClients
        $('#latestOffersPrev').on('click', function (e) {
            // prevent default anchor click behavior
            e.preventDefault();
            $('#latestOffers').trigger('prev.owl.carousel');
        });

        // Go to the previous item #ourClients
        $('#latestOffersNext').on('click', function (e) {
            // prevent default anchor click behavior
            e.preventDefault();
            // Parameters has to be in square bracket '[]'
            $('#latestOffers').trigger('next.owl.carousel', [300]);
        });
        /* ---------------------------------------------------------------------- */
        /*	travelSection
        /* ---------------------------------------------------------------------- */
        //Owl carousel #ourClients
        $('#travelSection').owlCarousel({
            items: 3,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                900: {
                    items: 2
                },
                1200: {
                    items: 3
                },
                1400: {
                    items: 3
                },
            },
            loop: true,
            center: false,
            dots: true,
            nav: false,
            margin: 20,
            rtl: true,
            autoplay: false,
            autoplayTimeout: 4000,
            dotsContainer: '#travelSectionDots',

        });
        // Go to the next item #ourClients
        $('#travelSectionPrev').on('click', function (e) {
            // prevent default anchor click behavior
            e.preventDefault();
            $('#travelSection').trigger('prev.owl.carousel');
        });

        // Go to the previous item #ourClients
        $('#travelSectionNext').on('click', function (e) {
            // prevent default anchor click behavior
            e.preventDefault();
            // Parameters has to be in square bracket '[]'
            $('#travelSection').trigger('next.owl.carousel', [300]);
        });
        /* ---------------------------------------------------------------------- */
        /*	flySection
        /* ---------------------------------------------------------------------- */
        //Owl carousel #ourClients
        $('#flySection').owlCarousel({
            items: 3,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                900: {
                    items: 2
                },
                1200: {
                    items: 3
                },
                1400: {
                    items: 3
                },
            },
            loop: true,
            center: false,
            dots: true,
            nav: false,
            margin: 20,
            rtl: true,
            autoplay: false,
            autoplayTimeout: 4000,
            dotsContainer: '#flySectionDots',

        });
        // Go to the next item #ourClients
        $('#flySectionPrev').on('click', function (e) {
            // prevent default anchor click behavior
            e.preventDefault();
            $('#flySection').trigger('prev.owl.carousel');
        });

        // Go to the previous item #ourClients
        $('#flySectionNext').on('click', function (e) {
            // prevent default anchor click behavior
            e.preventDefault();
            // Parameters has to be in square bracket '[]'
            $('#flySection').trigger('next.owl.carousel', [300]);
        });
        /* ---------------------------------------------------------------------- */
        /*	visaSection
        /* ---------------------------------------------------------------------- */
        //Owl carousel #ourClients
        $('#visaSection').owlCarousel({
            items: 3,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                900: {
                    items: 2
                },
                1200: {
                    items: 3
                },
                1400: {
                    items: 3
                },
            },
            loop: true,
            center: false,
            dots: true,
            nav: false,
            margin: 20,
            rtl: true,
            autoplay: false,
            autoplayTimeout: 4000,
            dotsContainer: '#visaSectionDots',

        });
        // Go to the next item #ourClients
        $('#visaSectionPrev').on('click', function (e) {
            // prevent default anchor click behavior
            e.preventDefault();
            $('#visaSection').trigger('prev.owl.carousel');
        });

        // Go to the previous item #ourClients
        $('#visaSectionNext').on('click', function (e) {
            // prevent default anchor click behavior
            e.preventDefault();
            // Parameters has to be in square bracket '[]'
            $('#visaSection').trigger('next.owl.carousel', [300]);
        });
        /* ---------------------------------------------------------------------- */
        /*	travelCarousel
        /* ---------------------------------------------------------------------- */
        //Owl carousel #travelCarousel
        $('#travelCarousel').owlCarousel({
            items: 3,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                900: {
                    items: 2
                },
                1200: {
                    items: 3
                },
                1400: {
                    items: 3
                },
            },
            loop: true,
            center: false,
            dots: true,
            nav: false,
            margin: 20,
            rtl: true,
            autoplay: false,
            autoplayTimeout: 4000,
            dotsContainer: '#travelCarouselDots',

        });
        // Go to the next item #ourClients
        $('#travelCarouselPrev').on('click', function (e) {
            // prevent default anchor click behavior
            e.preventDefault();
            $('#travelCarousel').trigger('prev.owl.carousel');
        });

        // Go to the previous item #ourClients
        $('#travelCarouselNext').on('click', function (e) {
            // prevent default anchor click behavior
            e.preventDefault();
            // Parameters has to be in square bracket '[]'
            $('#travelCarousel').trigger('next.owl.carousel', [300]);
        });
        // Select
        $(".js-example-basic-single").select2({
            placeholder: "اختار البلد",
            allowClear: true
        });
        $(".passengers").select2();
        $(".js-basic-single").select2({});
        // Datepicker
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

        $('.date-mask').on('focus', function () {
            $(this).mask('00/00/0000', {placeholder: "__/__/____"});
        }).on('change', function () {
            var val = $(this).val();
            var datParts = val.split("/");

            var dateCheck = moment(datParts[1] + "/" + datParts[0] + "/" + datParts[2]);

            console.log(dateCheck.isValid(), datParts);

            if(!dateCheck.isValid()) {
                console.log(val);
                alert("Date is invalid, please enter a valid date");
                $(this).val("")
            }
        });
    $("#bn2").breakingNews({
            effect: "slide-h",
            autoplay: true,
            timer: 3000,
            color: "yellow"
        });
    
        $('.gallery-item').magnificPopup({
            type: 'image',
            mainClass: 'mfp-fade',
            removalDelay: 300,
            gallery: {
                enabled: true
            }
        });

    });

    /* ---------------------------------------------------------------------- */
    /* Onresize
    /* ---------------------------------------------------------------------- */
    $(window).on('resize', function () {
        aspectRatio();
    });
    /* ---------------------------------------------------------------------- */
    /* Onload
    /* ---------------------------------------------------------------------- */
    $(window).on('load', function () {
        aspectRatio();
    });

});

