<div class="box">
    <div class="level">
        <div class="level-left">
            <div class="columns is-mobile">
                <div class="column is-narrow">
                    <img
                        src="{{ Str::of(isset($game['cover']) ? $game['cover']['url'] : '')->replace('thumb', 'logo_med')  }}"/>
                </div>
                <div class="column is-half">
                    <div class="text-gray-900 font-bold text-xl mb-2">
                        <a href="{{ LaravelLocalization::localizeUrl(route('games.show', ['slug' => $game['slug']])) }}"> {{ $game['name'] }} </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="level-left">
            <p class="text-gray-700">
                @if(isset($game['translate']['summary']) && $game['translate']['summary'] !== '')
                    {{ Str::of($game['translate']['summary'])->limit(150) }}
                @else
                    {{ Str::of(isset($game['summary']) ? $game['summary'] : '')->limit(150)  ?? '' }}
                @endif
            </p>
        </div>
    </div>

    <div class="level">
        <div class="level-left">
            <div class="text-sm">
                <p>
                    <b>Genres :</b>
                    @if (isset($game['genres']))
                        <span class="text-gray-900 leading-none">
                                {!! collect($game['genres'])->map(function($value) use($genre){
                                        if ( Str::ucFirst($genre) === $value['name']){
                                            return ['name' => '<b>'.$value['name'].'</b>'];
                                        }
                                        return ['name' => $value['name']];
                                    })->implode('name', ', ') !!}
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
                                {!! collect($game['platforms'])->map(function($value) use($platform){
                                        if ( $platform === $value['slug']){
                                            return ['platforms' => '<b>'.$value['name'].'</b>'];
                                        }

                                        return ['platforms' => $value['name']];
                                    })->implode('platforms', ', ') !!}
                            </span>
                    @endif
                </p>
                <p>
                    <b>Première date :</b>
                    <span class="text-gray-600">
                            @if (isset($game['first_release_date']) && is_string($game['first_release_date']))
                            {{ Carbon\Carbon::parse($game['first_release_date'])->toDateString() }}
                        @elseif (isset($game['first_release_date']) && $game['first_release_date'] instanceof Carbon\Carbon)
                            {{ $game['first_release_date']->toDateString() }}
                        @else
                            N.A
                        @endif
                        </span>
                </p>
            </div>
        </div>
    </div>
</div>

