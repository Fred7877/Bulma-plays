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
                            <div class="columns is-gapless is-multiline is-mobile mt-5">
                                <div class="column">Languages</div>
                                <div class="column ml-2 mt-1">
                                    {!! getFlag() !!}
                                </div>
                            </div>
                            <span class="icon is-small">
                              <i class="fas fa-angle-down" aria-hidden="true"></i>
                            </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu" role="menu">
                        <div class="dropdown-content">
                            <a href="{{ LaravelLocalization::getLocalizedURL('fr') }}" class="dropdown-item">
                                <div class="columns is-gapless is-multiline is-mobile">
                                    <div class="column">Français</div>
                                    <div class="column">
                                        {!! getFlag('FR') !!}
                                    </div>
                                </div>
                            </a>
                            <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="dropdown-item">
                                <div class="columns is-gapless is-multiline is-mobile">
                                    <div class="column">English</div>
                                    <div class="column">
                                        {!! getFlag('EN') !!}
                                    </div>
                                </div>
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

// Get all "navbar-burger" elements
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

// Check if there are any navbar burgers
            if ($navbarBurgers.length > 0) {

// Add a click event on each of them
                $navbarBurgers.forEach(el => {
                    el.addEventListener('click', () => {

// Get the target from the "data-target" attribute
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);

// Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');
                    });
                });
            }

        });
    </script>
@endpush
