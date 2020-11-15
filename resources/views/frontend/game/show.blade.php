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
        <div class="columns mb-0">
            @if(isset($game['cover']))
                <div class="column ">
                    <figure class="image static shadow-2xl">
                        <img
                            src="{{ Str::of(isset($game['cover']) ? $game['cover']['url'] : '')->replace('thumb', 'screenshot_big')  }}">
                    </figure>
                </div>
        @endif
        <!-- FICHE -->
            <div class="column">
                <div class="column is-full p-0">
                    <span class="title is-3">{{ $game['name'] }}</span>
                    <hr class="dropdown-divider">
                </div>
                <div class="columns mb-0">
                    <div class="column @if(isset($game['age_ratings'])) is-half @endif">
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
                            @if (isset($game['player_perspectives']))
                                <p>
                                    <b>Perspective :</b>
                                    <span class="text-gray-900 leading-none">
                                        {{ collect($game['player_perspectives'])->implode('name', ', ') }}
                                    </span>
                                </p>
                            @endif
                    </div>
                    @if(isset($game['age_ratings']))
                        <div class="column is-half">
                            <div class="columns">
                                @foreach($game['age_ratings'] as $ageRating)
                                    <div class="column is-2">
                                        <figure class="image is-48x48">
                                            <img src="{{ $ageRating }}" alt="">
                                        </figure>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
                <div class="columns">
                    <div class="column">
                        @if (isset($game['websites']))
                            <b>Links :</b>
                            <ul>
                                @foreach($game['websites'] as $siteweb)
                                    <li class="text-gray-900 leading-none">
                                        <a href="{{ $siteweb['url'] }}" class="word-break"
                                           target="_blank"> - {{ $siteweb['url'] }}
                                        </a>
                                        <span class="icon is-small has-text-info">
                                             <i class="fas fa-external-link-alt "></i>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="columns is-mobile">
                            <div class="column">
                                @if(isset($game['compagnies']))
                                    <div class="mt-2">
                                        <b>Produit par :</b>
                                        <ul>
                                            @foreach($game['compagnies'] as $compagny)
                                                <li class="text-gray-900 leading-none">
                                                    <a href="{{ $compagny->url }}" target="_blank">
                                                        - {{ $compagny->name }}
                                                    </a>
                                                    <span class="icon is-small has-text-info">
                                             <i class="fas fa-external-link-alt "></i>
                                        </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            @if (isset($game['aggregated_rating']))
                                <div class="column">
                                    <div
                                        class="mt-3 is-pulled-right rounded-full h-20 w-20 flex items-center justify-center bg-teal-500 text-xs text-white font-medium shadow-lg transform rotate-12">
                                        <div class="columns">
                                            <div class="column is-full text-xs text-center">
                                                <span class="text-xl"> {{ $game['aggregated_rating'] }}% </span>
                                                <hr class="dropdown-divider m-0">
                                                {{ $game['aggregated_rating_count'] }} voteurs
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- FICHE -->
        </div>
        <div class="block">
            <div class="content">
                @if(isset($game['summary']))
                    <b>Synopsis :</b>
                    <p>
                        @if(isset($game['translate']['summary']) && !empty($game['translate']['summary']))
                            {{ $game['translate']['summary']}}
                        @else
                            {{ $game['summary'] }}
                        @endif
                    </p>
                @endif
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


            var input = $('#myInput');
            input.on('keydown', function () {
                var key = event.keyCode || event.charCode;

                if (key == 8 || key == 46)
                    return false;
            });
        });
    </script>
@endpush
