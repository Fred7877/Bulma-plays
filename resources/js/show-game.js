require("fancybox");
require("owl.carousel");


$(document).ready(function () {

    var owlScreenshot = $('#carousel-screenshot');
    owlScreenshot.owlCarousel({
        margin: 10,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            960: {
                items: 3
            },
            1200: {
                items: 3
            }
        }
    });

    var owlVideo = $('#carousel-video');
    owlVideo.owlCarousel({
        items: 1,
        merge: true,
        margin: 10,
        video: true,
        lazyLoad: true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            500: {
                items: 1
            },
            600: {
                items: 1
            },
            700: {
                items: 1
            },
            800: {
                items: 2
            },
        }
    });

    $("a[id^=single_image]").fancybox();

});
