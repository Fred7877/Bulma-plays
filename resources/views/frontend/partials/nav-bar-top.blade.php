<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ LaravelLocalization::localizeUrl(route('games.index')) }}">
            <img src="{{ asset('storage/assets/images/logo_1.png') }}">
        </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasic">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasic" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="{{ LaravelLocalization::localizeUrl(route('games.index')) }}">
                <i class="fas fa-home"></i>
            </a>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="dropdown dropdown-languages">
                    <div class="dropdown-trigger">
                        <button id="languages" class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                            <span>Languages <b>({{Str::upper(App::getLocale()) }})</b> </span>
                            <span class="icon is-small">
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu" role="menu">
                        <div class="dropdown-content">
                            <a href="{{ LaravelLocalization::getLocalizedURL('fr') }}" class="dropdown-item">
                                Français
                            </a>
                            <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="dropdown-item">
                                English
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            document.getElementById("languages").addEventListener("click", function (e) {
                var element = document.querySelector(".dropdown-languages");
                element.classList.toggle("is-active");
            });

        });
    </script>
@endpush
