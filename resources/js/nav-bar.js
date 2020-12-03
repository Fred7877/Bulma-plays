const Swal = require('sweetalert2');
import route from 'ziggy';
import {Ziggy} from './ziggy';

document.addEventListener("DOMContentLoaded", (event) => {
    document.getElementById("languages").addEventListener("click", function (e) {
        var element = document.querySelector(".dropdown-languages");
        element.classList.toggle("is-active");
    });
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
            html: `
  <input type="text" id="name" class="swal2-input" placeholder="Pseudo">
  <input type="text" id="login" class="swal2-input" placeholder="@email">
  <input type="password" id="password" class="swal2-input" placeholder="Password">
  <input type="password" id="password_confirm" class="swal2-input" placeholder="Password confirm">
<i class="is-size-7 is-pulled-left">Pseudo must contain max 10 chars</i>
<i class="is-size-7 is-pulled-left">Password must contain min 8 characters, number, capital and lower letters</i>
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
                    Swal.showValidationMessage(`Pseudo must contain max 10 chars.`);
                    error = true;
                }

                if (!login || !password) {
                    Swal.showValidationMessage(`Please enter login and password.`);
                    error = true;
                }

                if (!validateEmail(login)) {
                    Swal.showValidationMessage(`The login must be an email valid.`);
                    error = true;
                }

                if (password.length < 6) {
                    Swal.showValidationMessage(`Password must contained min 6 characters.`);
                    error = true;
                }

                if (!validatePasswordFormat(password)) {
                    Swal.showValidationMessage(`Password format incorrect.`);
                    error = true;
                }

                if (password !== password_confirm) {
                    Swal.showValidationMessage(`The passwords are different.`);
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
                        }).then(document.location.reload())
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
