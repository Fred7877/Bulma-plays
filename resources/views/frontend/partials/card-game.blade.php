<div class="max-w-sm w-full lg:max-w-full lg:flex mb-4">
    <div class="flex-none img-content rounded-l-lg">
        <img src="{{ Str::of(isset($game['cover']) ? $game['cover']['url'] : '')->replace('thumb', 'logo_med')  }}"/>
    </div>
    <div
        class="w-full bg-white rounded-r-lg p-4 flex flex-col justify-between leading-normal">
        <div class="mb-2">
            <div class="text-gray-900 font-bold text-xl mb-2">
                <a href="{{ route('games.show', ['id' => $game['id']]) }}"> {{ $game['name'] }} </a>
            </div>
            <p class="text-gray-700 text-base">{{ Str::of(isset($game['summary']) ? $game['summary'] : '')->limit(150)  ?? '' }}</p>
        </div>
        <div class="flex items-center">
            <div class="text-sm">
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
                    <b>Première date :</b>
                    <span class="text-gray-600">
                        {{ isset($game['first_release_date']) ? $game['first_release_date']->toDateString() : '-' }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
