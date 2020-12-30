require("select2");
require("@fengyuanchen/datepicker");
require("fancybox");
require("owl.carousel");

const Swal = require('sweetalert2');
$(document).ready(() => {

    if ($('input[name="message"]').length > 0) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'Your work has been saved'
        })
    }

    $('.selector').select2();

    $.fn.datepicker.languages['fr'] = {format: 'dd/mm/yyyy'};
    $.fn.datepicker.languages['en'] = {format: 'mm/dd/yyyy'};

    let autoPick = false;
    let date = null;
    if ($('input[name="date_release"]').val() !== '') {
        let dateRelease = $('input[name="date_release"]').val().split('-');
        date = new Date(dateRelease[0], dateRelease[1], dateRelease[2]);
        autoPick = true;
    }

    $('#datepicker').datepicker(
        {
            language: $('input[name="locale"]').val(),
            autoHide: true,
            autoPick: autoPick,
            date: date
        }
    );


    $owlScreenshot = $('#carousel-screenshot').owlCarousel(
        {
            margin: 10,
            items: 3,
        }
    );

    owl = $('#carousel-screenshot').owlCarousel();
    $("a[id^=single_image]").fancybox();

    // Select
    $(document).on('select2:select', function (e) {
        if (e.target.id === 'platforms') {
            Livewire.emit('selectedPlatform', e.params.data.id);
        } else if (e.target.id === 'genres') {
            Livewire.emit('selectedGenre', e.params.data.id);
        } else if (e.target.id === 'gameModes') {
            Livewire.emit('selectedGameMode', e.params.data.id);
        } else if (e.target.id === 'themes') {
            Livewire.emit('selectedTheme', e.params.data.id);
        }
    });

    // Unselect
    $(document).on('select2:unselect', function (e) {
        if (e.target.id === 'platforms') {
            Livewire.emit('unSelectedPlatform', e.params.data.id);
        } else if (e.target.id === 'genres') {
            Livewire.emit('unSelectedGenre', e.params.data.id);
        } else if (e.target.id === 'gameModes') {
            Livewire.emit('unSelectedGameMode', e.params.data.id);
        } else if (e.target.id === 'themes') {
            Livewire.emit('unSelectedTheme', e.params.data.id);
        }
    });

    $(document).on('change', '#datepicker', function (e) {
        Livewire.emit('selectedDateRelease', e.target.value);
    });

    window.addEventListener('updatedNewScreenshotValues', event => {

        let html = `<a id='single_image-` + (event.detail.position - 1) + `'
                     href='` + event.detail.temporaryUrl + `'>
                         <img src="` + event.detail.temporaryUrl + `">
                     </a>
                     <input type="hidden" name="screenshotsHidden[(event.detail.position - 1)]" value="`+event.detail.temporaryUrl+`">`;

        owl.trigger('add.owl.carousel', [html], event.detail.position - 1).trigger('refresh.owl.carousel');
        $("a[id^=single_image]").fancybox();
    });

    window.addEventListener('removeScreenshot', event => {
        owl.trigger('remove.owl.carousel', event.detail.position).trigger('refresh.owl.carousel');
    });
});

