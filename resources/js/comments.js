const Swal = require('sweetalert2');
$(document).ready(() => {

    $('#add-comments').on('click', function () {
        $('#comments_area').toggle();
    });

    $('#add-tips').on('click', function () {
        $('#tips_area').toggle();
    });

    $('.answer-comments').on('click', function (elem) {
        $('#comments_area_answer-' + elem.target.dataset.idComment).toggle();

        if ($(elem.target).css('visibility') === 'hidden')
            $(elem.target).css('visibility', 'visible');
        else
            $(elem.target).css('visibility', 'hidden');

    });

    $('.answers-answers').on('click', function (elem) {

        let reply = elem.target.dataset.reply;
        let authorName = elem.target.dataset.authorName;
        let replyId = elem.target.dataset.replyId;
        let typeComment = elem.target.dataset.type;
        let typeTxt = elem.target.dataset.typeTxt;
        let gameId = elem.target.dataset.gameId;

        let htmlModal = `<div class="columns">
    <div class="column">
        <div class="row">
            <div class="has-text-left">
                <h5>Répondre à :</h5>
                 <div class="level m-0 has-background-grey has-text-white p-1">
                    <div class="is-size-7">`
            + authorName +
            `</div>
                 </div>
                 <div class="mt-2 mb-2">
                   ` + reply + `
                </div>
                <textarea class="textarea" name="reply"></textarea>
            </div>
        </div>
    </div>`;
        Swal.fire({
            showCloseButton: true,
            allowEnterKey: true,
            html: htmlModal,
            confirmButtonText: 'Envoyer',
            focusConfirm: false,
            preConfirm: () => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: route('comments.create'),
                    method: 'post',
                    data: {
                        comment: $('textarea[name=reply]').val(),
                        type: typeComment,
                        parentCommentId: replyId,
                        gameId: gameId,
                    }
                }).done(() => {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: typeTxt.toUpperCase() + ' Added !',
                        showConfirmButton: false,
                        timer: 2000,
                        text: "Ton message sera soumis à une modération.",
                    })
                }).fail(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                });
            }
        })
    });


    $('.leave-comment').on('click', function (elem) {

        let typeComment = elem.target.dataset.type;
        let typeTxt = elem.target.dataset.typeTxt;
        let gameId = elem.target.dataset.gameId;

        let htmlModal = `<div class="columns">
    <div class="column">
        <div class="row">
            <div class="has-text-left">
                <h5>Laisser un commentaire :</h5>
                <textarea class="textarea" name="reply"></textarea>
            </div>
        </div>
    </div>`;
        Swal.fire({
            showCloseButton: true,
            allowEnterKey: true,
            html: htmlModal,
            confirmButtonText: 'Envoyer',
            focusConfirm: false,
            preConfirm: () => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: route('comments.create'),
                    method: 'post',
                    data: {
                        comment: $('textarea[name=reply]').val(),
                        type: typeComment,
                        parentCommentId: null,
                        gameId: gameId,
                    }
                }).done(() => {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: typeTxt.toUpperCase() + ' Added !',
                        showConfirmButton: false,
                        timer: 2000,
                        text: "Ton message sera soumis à une modération.",
                    })
                }).fail(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                });
            }
        })
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
