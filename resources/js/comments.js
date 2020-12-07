const Swal = require('sweetalert2');
$(document).ready(() => {

    $('#add-comments').on('click', function () {
        $('#comments_area').toggle();
    });

    $('#add-tips').on('click', function () {
        $('#tips_area').toggle();
    });

    $('.answer-comments').on('click', function (elem) {
        $('#comments_area_answer-'+elem.target.dataset.idComment).toggle();

        if ( $(elem.target).css('visibility') === 'hidden' )
            $(elem.target).css('visibility','visible');
        else
            $(elem.target).css('visibility','hidden');
    });

    $('.answers-answers').on('click', function (elem) {
        console.log(elem.target.dataset.idComment);
        $('#comments_area_answers-answers-'+elem.target.dataset.idComment).toggle();

        if ( $(elem.target).css('visibility') === 'hidden' )
            $(elem.target).css('visibility','visible');
        else
            $(elem.target).css('visibility','hidden');
    });

    window.addEventListener('commentAdded', event => {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: event.detail.type.toUpperCase() + ' Added !',
            showConfirmButton: false,
            timer: 2000,
            text: "Ton message sera soumis à une modération.",
        })
        $('#comments_area').hide();
        $('#tips_area').hide();
    });

    // ### TABS comments and tips ###
    var tabs = document.getElementsByClassName('tabs');
    if (tabs) {
        var _loop = function _loop() {
            var tabListItems = tabs[i].querySelectorAll('li');
            tabListItems.forEach(function (tabListItem) {
                toggleDarkWhiteClass(tabListItem);

                tabListItem.addEventListener('click', function (el) {
                    tabListItems.forEach(function (tabListItem) {
                        tabListItem.classList.remove('is-active');

                        for (var i = 0; i < tabListItem.children.length; i++) {
                            tabListItem.children[i].classList.remove('has-text-dark');
                            tabListItem.children[i].classList.add('has-text-white');
                        }
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
});

function toggleDarkWhiteClass(elem) {
    elem.addEventListener('mouseover', (el) => {
        if (!elem.classList.contains('is-active') && el.parentNode !== elem) {
            for (var i = 0; i < elem.children.length; i++) {
                elem.children[i].classList.remove('has-text-white');
                elem.children[i].classList.add('has-text-dark');
            }
        }
    });

    elem.addEventListener('mouseout', (el) => {
        if (!elem.classList.contains('is-active') && el.parentNode !== elem) {
            for (var i = 0; i < elem.children.length; i++) {
                elem.children[i].classList.remove('has-text-dark');
                elem.children[i].classList.add('has-text-white');
            }
        }
    });
}
