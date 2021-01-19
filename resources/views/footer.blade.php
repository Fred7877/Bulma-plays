<footer class="footer mt-5 pb-5 is-size-7" id="footer">
    <div class="container mx-auto ">
        <div class="columns">
            <div class="column">
                <div class="row">
                    <p class="has-text-weight-medium">
                        {{ __('frontend.site_works_thanks_to') }} <a href="https://api-docs.igdb.com/#about" target="_blank">IGDB</a>
                    </p>
                </div>
                <div class="row">
                    <p>Contact: <a href="mailto:admin@bulma-playz.com">admin@bulma-playz.com</a></p>
                </div>
            </div>

            <div class="column">
                <div class="row">
                    <p class="has-text-weight-medium">{{ __('frontend.your_favorite_games') }} :</p>
                </div>
                <div class="row">
                    <p>
                        <a href="{{ route('filter.game', ['platformSlug' => 'win', 'platformName' => 'PC (Microsoft Windows)']) }}">
                            Windows
                        </a>
                    </p>
                </div>
                <div class="row">
                    <a href="{{ route('filter.game', ['platformSlug' => 'linux', 'platformName' => 'Linux']) }}">
                        Linux
                    </a>
                </div>
                <div class="row">
                    <p>
                        <a href="{{ route('filter.game', ['platformSlug' => 'switch', 'platformName' => 'Nintendo Switch']) }}">
                            Nintendo Switch
                        </a>
                    </p>
                </div>
                <div class="row">
                    <p>
                        Playstation
                        <a href="{{ route('filter.game', ['platformSlug' => 'ps3', 'platformName' => 'PlayStation 3']) }}">
                            3
                        </a>
                        /
                        <a href="{{ route('filter.game', ['platformSlug' => 'ps4--1', 'platformName' => 'PlayStation 4']) }}">
                            4
                        </a>
                        /
                        <a href="{{ route('filter.game', ['platformSlug' => 'ps5', 'platformName' => 'PlayStation 5']) }}">
                            5
                        </a>
                    </p>
                </div>
            </div>

            <div class="column">
                <p class="has-text-weight-medium">{{ __('frontend.homemade_games') }}</p>
                <ul>
                @foreach(\App\Models\CustomGame::whereHas('moderations', function(\Illuminate\Database\Eloquent\Builder $query){
                               $query->where('status', true);
                        })->limit(5)->orderByDesc('created_at')->get() as $game)
                    <li>
                        <a href="{{ route('custom-game.show', ['slug' => $game->slug]) }}">
                        {{ $game->name }}
                        </a>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>
