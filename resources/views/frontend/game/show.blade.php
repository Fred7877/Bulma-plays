@extends('frontend.main')

@section('content')
    <div class="box">
        <div class="rows">
            <div class="columns">
                <div class="column">
                    <figure class="image is-1by1">
                        <img
                            src="{{ Str::of(isset($game['cover']) ? $game['cover']['url'] : '')->replace('thumb', 'cover_big')  }}">
                    </figure>
                </div>
                <!-- FICHE -->
                <div class="column">
                    <p>
                        <b>Name :</b>
                        {{ $game['name'] }}
                    </p>
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
                                        class="underline">Max coop online :</span> {{ $multiplayerMode['onlinecoopmax'] ? 'Oui' : 'Non' }}
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
                        <p>
                            <b>Links :</b>
                        @if (isset($game['websites']))
                            <ul>
                                @foreach($game['websites'] as $siteweb)
                                    <li class="text-gray-900 leading-none">
                                        <a href="{{ $siteweb['url'] }}" target="_blank">{{ $siteweb['url'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                            </p>
                </div>
                <!-- FICHE -->
            </div>
            <div class="block">
                <div class="content">
                    <p>
                        @if(isset($game['translate']['summary']))
                            {{ $game['translate']['summary']}}
                        @endif
                    </p>
                </div>
            </div>
            <div class="block has-background-dark p-4 rounded">
                <div class="columns">
                    @foreach($game['screenshots'] as $screenshot)
                        @if (isset($screenshot['url']))
                            <div class="column">
                                <img class="image is-128x128"
                                     src="{{ Str::of($screenshot['url'])->replace('thumb', 'screenshot_med')  }}"
                                >
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            @if (isset($game['videos']))
                <div class="block has-background-dark p-4 rounded">

                    <div class="columns">
                        @foreach($game['videos'] as $video)
                            <div class="column is-variable is-1-mobile is-0-tablet is-3-desktop is-4-widescreen">
                                <iframe
                                    src="https://www.youtube.com/embed/{{ $video['video_id'] }}">
                                </iframe>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
