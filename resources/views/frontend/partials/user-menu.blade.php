<div class="dropdown-trigger">
    <button id="nav-user-{{ $device }}" class="button" aria-haspopup="true" aria-controls="dropdown-menu">
        <span><i class="fas fa-ellipsis-h"></i></span>
    </button>
</div>
<div class="dropdown-menu" id="dropdown-menu-{{ $device }}" role="menu">
    <div class="dropdown-content">
        <a href="#" class="dropdown-item" id="btn-profil">
            Profil
        </a>
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
