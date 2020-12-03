require("fancybox");
require("owl.carousel");
const Swal = require('sweetalert2');

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

    $('#add-comments').on('click', function(){
        console.log('#add-comments');
        $('#comments_area').toggle();
    });

    $('#add-tips').on('click', function(){
        console.log('#add-tips');
        $('#tips_area').toggle();
    });

    window.addEventListener('commentAdded', event => {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: event.detail.type.toUpperCase()+' Added !',
            showConfirmButton: false,
            timer: 2000,
            text: "Ton message sera soumis à une modération.",
        })
        $('#comments_area').hide();
        $('#tips_area').hide();
    });
});

var tabs = document.getElementsByClassName('tabs');
if (tabs) {
    var _loop = function _loop() {
        var tabListItems = tabs[i].querySelectorAll('li');
        tabListItems.forEach(function (tabListItem) {
            tabListItem.addEventListener('click', function () {
                tabListItems.forEach(function (tabListItem) {
                    tabListItem.classList.remove('is-active');
                });
                tabListItem.classList.add('is-active');
                var tabName = tabListItem.dataset.tab;
                tabListItem.closest('.js-tabs-container').querySelectorAll('.js-tab-content').forEach(function (tabContent) {
                    if (tabContent.id !== tabName) {
                        tabContent.classList.add('has-display-none');
                    } else {
                        tabContent.classList.remove('has-display-none');
                    }
                });
            }, false);
        });
    };

    for (var i = 0; i < tabs.length; i++) {
        _loop();
    }
}

