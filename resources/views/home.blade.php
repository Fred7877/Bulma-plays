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
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3267490048749348"
            crossorigin="anonymous"></script>
    <!-- Bloc1 -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-3267490048749348"
         data-ad-slot="6345150642"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
@endsection
