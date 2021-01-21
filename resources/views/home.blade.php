@extends('frontend.main')

@section('content')
    <div class="box mt-5">
        <article class="media">
            <div class="media-content">
                <div class="content">
                    {!!
                        sprintf(
                            __('frontend.speach_home'),
                            '/'.App::getLocale()."/games/cathode-ray-tube-amusement-device",
                            route('filter.game', ['platformSlug' => 'switch', 'platformName' => 'Nintendo Switch']),
                            route('filter.game', ['platformSlug' => 'ps4--1', 'platformName' => 'PlayStation 4']),
                            route('filter.game', ['platformSlug' => 'linux', 'platformName' => 'Linux']),
                            route('filter.game', ['platformSlug' => 'win', 'platformName' => 'PC (Microsoft Windows)']),
                            route('homemade.games.index'),
                            route('games.index'),
                        )
                        !!}
                </div>
            </div>
        </article>
    </div>
@endsection
