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
                            <b>{{ Str::ucFirst(__('frontend.first_release_date'))  }} :</b>
                            @if (isset($game['first_release_date']) && is_string($game['first_release_date']))
                                {{ Carbon\Carbon::parse($game['first_release_date'])->toDateString() }}
                            @elseif (isset($game['first_release_date']) && $game['first_release_date'] instanceof Carbon\Carbon)
                                {{ $game['first_release_date']->toDateString() }}
                            @else
                                N.A
                            @endif
                        </p>
                        <p>
                            @if (isset($game['genres']))
                                <b>{{ Str::ucFirst( Str::plural(__('genre'), count($game['genres'])) ) }} :</b>
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
                            <b>{{ Str::ucFirst(Str::plural(__('frontend.platform'), count($game['platforms']))) }} :</b>
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
                        <p>
                            @if (isset($game['themes']))
                                <b>{{ Str::ucFirst(Str::plural(__('frontend.theme'), count($game['themes']))) }}
                                    :</b>
                                <span class="text-gray-900 leading-none">
                                        {{ collect($game['themes'])->implode('name', ', ') }}
                                    </span>
                            @endif
                        </p>
                        @if (isset($game['player_perspectives']))
                            <p>
                                <b>{{ Str::ucFirst(Str::plural('Perspective', count($game['player_perspectives']))) }}
                                    :</b>
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
                                        <b>{{ Str::ucFirst(__('frontend.produced_by')) }} :</b>
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
                                                {{ $game['aggregated_rating_count'] }} {{ Str::plural(__('frontend.voter'), $game['aggregated_rating_count']) }}
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
        <hr class="dropdown-divider">

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

    @if(Auth::check())
        <div class="block has-background-dark p-4 rounded">
            <div class="container js-tabs-container">
                <div class="tabs is-toggle is-fullwidth">
                    <ul>
                        <li class="is-active" data-tab="tab-comments">
                            <a class="has-text-white">
                                <span class="icon is-small"><i class="fas fa-lg fa-comments"
                                                               aria-hidden="true"></i></span>
                                <span>Commentaires et Avis</span>
                            </a>
                        </li>
                        <li data-tab="tab-tips">
                            <a class="has-text-white">
                                <span class="icon is-small"><i class="fas fa-lg fa-comment-medical"
                                                               aria-hidden="true"></i></span>
                                <span>Trucs & Asctuces</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="js-tab-content" id="tab-comments">
                    <article class="message is-dark">
                        <div class="message-body">
                            <livewire:comment :game="$game" :type="\App\Enums\CommentType::Comments"/>
                        </div>
                    </article>
                </div>
                <div class="has-display-none js-tab-content" id="tab-tips">
                    <div class="js-tab-content" id="tab-tips">
                        <article class="message is-dark">
                            <div class="message-body">
                                <livewire:comment :game="$game" :type="\App\Enums\CommentType::Tips"/>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('js')
    <script src="/js/show-game.js"></script>
@endpush
