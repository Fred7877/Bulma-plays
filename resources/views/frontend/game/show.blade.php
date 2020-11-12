@extends('frontend.main')

@section('content')
    <div class="box mt-3">
        <div class="is-hidden-desktop">
            <a href="{{ LaravelLocalization::localizeUrl(route('games.index')) }}">
                <button class="button is-small mb-3 is-primary is-rounded">
                    <i class="fas fa-arrow-circle-left"></i>
                </button>
            </a>
        </div>
        <div class="columns">
            <div class="column ">
                @if(isset($game['cover']))
                    <figure class="image is-1by1 static">
                        <img
                            src="{{ Str::of(isset($game['cover']) ? $game['cover']['url'] : '')->replace('thumb', 'screenshot_big')  }}">
                        @if(isset($game['aggregated_rating']))
                            <div class="absolute bottom-0 right-0" style="right:-40px; bottom:-40px">
                                <div
                                    class="shadow-2xl  rounded-full h-24 w-24 flex items-center justify-center text-white font-black text-4xl bg-gray-800">
                                    {{  $game['aggregated_rating'] }}%
                                </div>
                            </div>
                        @endif
                    </figure>
                @endif
            </div>

            <!-- FICHE -->
            <div class="column is-relative">
                <p>
                    <span class="title is-3">{{ $game['name'] }}</span>
                </p>
                <hr class="dropdown-divider">
                <p>
                    <b>Date première version :</b>
                    @if (isset($game['first_release_date']) && is_string($game['first_release_date']))
                        {{ Carbon\Carbon::parse($game['first_release_date'])->toDateString() }}
                    @elseif (isset($game['first_release_date']) && $game['first_release_date'] instanceof Carbon\Carbon)
                        {{ $game['first_release_date']->toDateString() }}
                    @else
                        N.A
                    @endif
                </p>
                <p>
                    <b>Genres :</b>
                    @if (isset($game['genres']))
                        <span class="text-gray-900 leading-none">
                            {{ collect($game['genres'])->implode('name', ', ') }}
                        </span>
                    @else
                        <span class="text-gray-900 leading-none">
                            N.A
                        </span>
                    @endif
                </p>
                <p>
                    <b>Platforms :</b>
                    @if (isset($game['platforms']))
                        <span class="text-gray-900 leading-none">
                            {{ collect($game['platforms'])->implode('name', ', ') }}
                        </span>
                    @endif
                </p>
                <p>
                    <b>Game mode :</b>
                    @if (isset($game['game_modes']))
                        <span class="text-gray-900 leading-none">
                            {{ collect($game['game_modes'])->implode('name', ', ') }}
                        </span>
                    @endif
                </p>
                @if (isset($game['multiplayer_modes']))
                    <p>
                        <b>Mode multijoueur :</b>
                    <p>
                    <ul>
                        @foreach($game['multiplayer_modes'] as $multiplayerMode)
                            <li>
                                    <span
                                        class="underline">Lan :</span> {{ $multiplayerMode['lancoop'] ? 'Oui' : 'Non' }}
                            </li>
                            <li>
                                    <span
                                        class="underline">Coop offline :</span> {{ $multiplayerMode['offlinecoop'] ? 'Oui' : 'Non' }}
                            </li>
                            <li>
                                    <span
                                        class="underline">Coop online :</span> {{ $multiplayerMode['onlinecoop'] ? 'Oui' : 'Non' }}
                            </li>
                            <li>
                                    <span
                                        class="underline">Max coop online :</span> {{ isset($multiplayerMode['onlinecoopmax']) ? 'Oui' : 'Non' }}
                            </li>
                        @endforeach
                    </ul>
                    @endif
                    </p>
                    </p>
                    <p>
                        <b>Thèmes :</b>
                        @if (isset($game['themes']))
                            <span class="text-gray-900 leading-none">
                            {{ collect($game['themes'])->implode('name', ', ') }}
                        </span>
                        @endif
                    </p>
                    <p>
                        <b>Perspective :</b>
                        @if (isset($game['player_perspectives']))
                            <span class="text-gray-900 leading-none">
                            {{ collect($game['player_perspectives'])->implode('name', ', ') }}
                        </span>
                        @endif
                    </p>
                    <b>Links :</b>

                    @if (isset($game['websites']))
                        <ul>
                            @foreach($game['websites'] as $siteweb)
                                <li class="text-gray-900 leading-none">
                                    <a href="{{ $siteweb['url'] }}" class="word-break"
                                       target="_blank"> - {{ $siteweb['url'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
            </div>
            <!-- FICHE -->
        </div>
        <div class="block">
            <div class="content">
                <b>Synopsis :</b>
                <p>
                    @if(isset($game['translate']['summary']) && !empty($game['translate']['summary']))
                        {{ $game['translate']['summary']}}
                    @else
                        {{ $game['summary'] }}
                    @endif
                </p>
            </div>
        </div>
        @if (isset($game['screenshots']))
            <div class="block has-background-dark p-4 rounded">
                <div class="owl-carousel owl-theme" id="carousel-screenshot">
                    @foreach($game['screenshots'] as $screenshot)
                        @if (isset($screenshot['url']))
                            <a id="single_image-{{ $loop->index }}"
                               href="{{ Str::of($screenshot['url'])->replace('thumb', 'screenshot_huge')  }}">
                                <img src="{{ Str::of($screenshot['url'])->replace('thumb', 'screenshot_med')  }}">
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        @if (isset($game['videos']))
            <div class="block has-background-dark p-4 rounded">
                <div class="owl-carousel owl-theme" id="carousel-video">
                    @foreach($game['videos'] as $video)
                        <iframe class="item-video" data-merge="1"
                                src="https://www.youtube.com/embed/{{ $video['video_id'] }}"></iframe>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@endsection
@push('js')
    <script src="{{ asset('storage/assets/js/Jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('storage/assets/OwlCarousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('storage/assets/js/fancyBox-3.5.7.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("a[id^=single_image]").fancybox();

            var owlScreenshot = $('#carousel-screenshot');
            owlScreenshot.owlCarousel({
                margin: 10,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    960: {
                        items: 3
                    },
                    1200: {
                        items: 3
                    }
                }
            });

            var owlVideo = $('#carousel-video');
            owlVideo.owlCarousel({
                items: 1,
                merge: true,
                margin: 10,
                video: true,
                lazyLoad: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    480: {
                        items: 1
                    },
                    500: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    700: {
                        items: 1
                    },
                    800: {
                        items: 2
                    },
                }
            });
        });
    </script>
@endpush
