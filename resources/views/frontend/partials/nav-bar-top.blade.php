<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ LaravelLocalization::localizeUrl(route('home')) }}">
            <img src="{{ asset('storage/assets/images/logo_1.png') }}">
        </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasic">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasic" class="navbar-menu">
        @if (Route::currentRouteName() === 'games.show' ||
             Route::currentRouteName() === 'custom-game.show' ||
             Route::currentRouteName() === 'custom-game.edit')
            <div class="navbar-start is-hidden-mobile">
                <a class="navbar-item" href="{{ LaravelLocalization::localizeUrl(route('games.index')) }}">
                    <i class="fas fa-list-ul icon is-medium"></i>
                </a>
            </div>
        @endif
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
            @if(!Auth::check())
                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-primary" id="btn-signup">
                                <strong>{{ __('frontend.sign_in') }}</strong>
                            </a>
                            <a class="button is-light" id="btn-login">
                                {{ __('frontend.log_in') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            @if(Auth::check())
                <div class="navbar-end mr-3 mt-2">
                    <div class="dropdown dropdown-menu-user is-right">
                        <div class="dropdown-trigger">
                            <button id="nav-user" class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                <span><i class="fas fa-ellipsis-h"></i></span>
                            </button>
                        </div>
                        <div class="dropdown-menu" id="dropdown-menu" role="menu">
                            <div class="dropdown-content">
                                <hr class="dropdown-divider m-0">
                                <a href="{{ route('custom-game.create') }}" class="dropdown-item" id="btn-create-game">
                                    {{ __('frontend.create_custom_game') }}
                                </a>
                                <hr class="dropdown-divider m-0">
                                <a href="{{ route('comments.user') }}" class="dropdown-item" id="btn-comments-user">
                                    {{ __('frontend.my_comments') }}
                                </a>
                                <a href="{{ route('list.custom-games.user') }}" class="dropdown-item">
                                    {{ __('frontend.my_homemade_games') }}
                                </a>
                                <div class="dropdown-item">
                                    <a class="button is-dark is-small" id="btn-logout"
                                       href="{{ route('gamers.logout') }}">
                                        {{ __('frontend.log_out') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <meta name="_token" content="{{ csrf_token() }}">
</nav>

@push('js')
    <script src="/js/nav-bar.js"></script>
    <script src="/js/menu-user.js"></script>
@endpush
