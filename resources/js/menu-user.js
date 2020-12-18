const Swal = require('sweetalert2');

document.addEventListener("DOMContentLoaded", () => {
    // PROFIL
    if (document.body.contains(document.getElementById("nav-user"))) {
        document.getElementById("btn-profil").addEventListener("click", function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "get",
                url: "get-user",
            }).done((user) => {
                Swal.fire({
                    html: `<div class="row" id="modal-user">
                                <div class="columns">
                                    Pseudo : ` + user.name + `
                                </div>
                                <div class="columns">
                                    Email : ` + user.email + `
                                </div>
                            </div>`,
                });
            });
        });

        // CONTRIBUTIONS
        document.getElementById("btn-comments-user").addEventListener("click", function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "get",
                url: "get-comments-user",
            }).done((comments) => {
                html = '';

                for (let c in comments) {
                    html += comments[c].comment;
                }
                Swal.fire({
                    html: `<div class="row" id="modal-user">`
                        + html +
                        `</div>`,
                });
            });
        });

        // Create game
        /*document.getElementById("btn-comments-user").addEventListener("click", function (e) {
            Swal.fire({
                html: `<div class="row" id="modal-create-game">
                    <input id="date_first_release" name="date_first_release">
                    <input id="platform" name="platform">
                    </div>`,
            });
        });*/
    }
});



