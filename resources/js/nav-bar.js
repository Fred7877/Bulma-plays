const Swal = require('sweetalert2');

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("languages").addEventListener("click", function (e) {
        var element = document.querySelector(".dropdown-languages");
        element.classList.toggle("is-active");
    });

    if (document.body.contains(document.getElementById("nav-user")) ) {
        document.getElementById("nav-user").addEventListener("click", function (e) {
            var element = document.querySelector(".dropdown-menu-user");
            element.classList.toggle("is-active");
        });
    }

    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    if ($navbarBurgers.length > 0) {

        $navbarBurgers.forEach(el => {
            el.addEventListener('click', () => {

                const target = el.dataset.target;
                const $target = document.getElementById(target);

                el.classList.toggle('is-active');
                $target.classList.toggle('is-active');
            });
        });
    }

    // SIGN UP
    $('#btn-signup').on('click', function () {
        Swal.fire({
            title: 'Sign up !',
            showCloseButton: true,
            allowEnterKey: true,
            html: `
  <input type="text" id="name" class="swal2-input" placeholder="Pseudo">
  <input type="text" id="login" class="swal2-input" placeholder="@email">
  <input type="password" id="password" class="swal2-input" placeholder="Password">
  <input type="password" id="password_confirm" class="swal2-input" placeholder="Password confirm">
<i class="is-size-7 is-pulled-left">`+Lang.get('frontend.pseudo_must_contain')+`</i>
<i class="is-size-7 is-pulled-left">`+Lang.get('frontend.password_must_contain')+`</i>
`,
            confirmButtonText: 'Sign in',
            focusConfirm: false,
            preConfirm: () => {
                const name = Swal.getPopup().querySelector('#name').value
                const login = Swal.getPopup().querySelector('#login').value
                const password = Swal.getPopup().querySelector('#password').value
                const password_confirm = Swal.getPopup().querySelector('#password_confirm').value

                let error = false;
                if (name.length > 8) {
                    Swal.showValidationMessage(Lang.get('frontend.error_pseudo'));
                    error = true;
                }

                if (!login || !password) {
                    Swal.showValidationMessage(Lang.get('frontend.login_pass_mandatory'));
                    error = true;
                }

                if (!validateEmail(login)) {
                    Swal.showValidationMessage(Lang.get('frontend.login_must_be_email'));
                    error = true;
                }

                if (password.length < 6) {
                    Swal.showValidationMessage(Lang.get('frontend.password_6_char_min'));
                    error = true;
                }

                if (!validatePasswordFormat(password)) {
                    Swal.showValidationMessage(Lang.get('frontend.password_format_incorrect'));
                    error = true;
                }

                if (password !== password_confirm) {
                    Swal.showValidationMessage(Lang.get('frontend.password_not_match'));
                    error = true;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    }
                });

                if (!error) {
                    $.ajax({
                        type: 'post',
                        url: '/gamers-register',
                        data: {
                            name: name,
                            email: login,
                            password: password,
                            password_confirmation: password_confirm
                        }
                    }).done(function () {
                        Swal.fire({
                            title: 'Bienvenue ' + name + ' !',
                            html: `<i class="is-size-7 is-pulled-left">Tu vas pouvoir te logger avec tes identifiants :)</i>`
                        })
                    }).fail(function (errors) {
                        let message = '';
                        $.each(errors.responseJSON.errors, function (i, error) {
                            message += error+'<br>';
                        });
                        Swal.showValidationMessage(message)
                    })
                }

                return false;
            }
        })
    });


    // Log IN
    $('#btn-login').on('click', function () {
        Swal.fire({
            title: 'Log IN !',
            showCloseButton: true,
            allowEnterKey: true,
            html: `
  <input type="text" id="login" class="swal2-input" placeholder="@email">
  <input type="password" id="password" class="swal2-input" placeholder="Password">
`,
            confirmButtonText: 'Log in',
            focusConfirm: false,
            preConfirm: () => {
                const login = Swal.getPopup().querySelector('#login').value
                const password = Swal.getPopup().querySelector('#password').value

                let error = false;

                if (!login || !password) {
                    Swal.showValidationMessage(`Please enter login and password.`);
                    error = true;
                }

                if (!validateEmail(login)) {
                    Swal.showValidationMessage(`The login must be an email valid.`);
                    error = true;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    }
                });

                if (!error) {
                    $.ajax({
                        type: 'get',
                        url: '/gamers-login',
                        data: {
                            email: login,
                            password: password,
                        }
                    }).done(function (response) {
                        Swal.fire({
                            title: 'Bienvenue '+ response.name +' !',
                            timer: 5000,
                            showConfirmButton: false,
                            background: '#fff url(/images/trees.png)',
                            backdrop: `
                            rgba(0,0,123,0.4)
                            url("/storage/assets/images/tenor.gif")
                            left top
                            no-repeat
                          `
                        }).then(document.location.reload());
                    }).fail(function (error) {
                        Swal.showValidationMessage(error.responseJSON.error)
                    })
                }

                return false;
            }
        })
    });



});

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validatePasswordFormat(password) {
    const re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    return re.test(String(password));
}
