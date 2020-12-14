<div class="box p-0 mb-3 ">
    <article class="media">
        <div class="media-left">
            <figure class="image">
                <img
                    src="{{ Str::of(isset($game['cover']) ? $game['cover']['url'] : '')->replace('thumb', 'logo_med')  }}"/>
            </figure>
        </div>
        <div class="media-content">
            <div class="content">
                <p>
                <h4 class="title is-4 mt-0 mb-0">
                    <a href="{{ LaravelLocalization::localizeUrl(route('games.show', ['slug' => $game['slug']])) }}"> {{ $game['name'] }} </a>
                </h4>
                @if(isset($game['translate']['summary']) && $game['translate']['summary'] !== '')
                {{ Str::of($game['translate']['summary'])->limit(150) }}
                @else
                {{ Str::of(isset($game['summary']) ? $game['summary'] : '')->limit(150)  ?? '' }}
                @endif
                </p>

                <div class="is-flex-direction-row">
                    <div class="is-flex-direction-row">
                        <b>Genres :</b>
                        @if (isset($game['genres']))
                            <span class="text-gray-900 leading-none">
                            {!! collect($game['genres'])->map(function($value) use($genre){
                                    if ( Str::ucFirst($genre) === $value['slug']){
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
                    </div>
                    <div class="is-flex-direction-row">
                        <b>Platforms :</b>
                        @if (isset($game['platforms']))
                            <span class="text-gray-900 leading-none">
                            {!! collect($game['platforms'])->map(function($value) use($platform){
                                    if ( $platform === $value['slug']){
                                        return ['platforms' => '<span class="has-text-primary has-text-weight-bold ">'.$value['name'].'</span>'];
                                    }

                                    return ['platforms' => $value['name']];
                                })->implode('platforms', ', ') !!}
                        </span>
                        @endif
                    </div>
                    <div class="is-flex-direction-row">
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
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
