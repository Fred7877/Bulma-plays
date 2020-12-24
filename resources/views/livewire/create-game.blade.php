<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <form method="post" action="{{ $actionForm }}">
        @if($actionMethod === 'put')
            @method('put')
        @endif
        @csrf
        <div class="mt-3">
            <div class="columns">
                <div class="column is-3">
                    <div class="box mt-3">
                        <aside class="menu">
                            <p class="menu-label">
                                Références
                            </p>
                            <!-- BEGIN FORM -->
                            <ul class="menu-list">
                                <li>
                                    <label class="label">Titre</label>
                                    <div class="control">
                                        <input class="input is-small" type="text" name="title" wire:model="title">
                                    </div>
                                </li>
                                <li class="mt-4">
                                    <label class="label">Date première version</label>
                                    <input class="input is-small" id="datepicker" name="date_release">
                                </li>
                                <li class="mt-4">
                                    <label class="label">Themes</label>
                                    <div class="control" wire:ignore>
                                        <select name="themes[]" multiple="multiple" id="themes" style="width: 100%">
                                            <option disabled="disabled">Choose genres</option>
                                            @foreach($themes as $theme)
                                                <option value="{{ $theme->id }}"
                                                        @if(isset($this->themesSelected[$theme->id])) selected="selected" @endif >{{ $theme->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                <li class="mt-4">
                                    <label class="label">Genre</label>
                                    <div class="control" wire:ignore>
                                        <select name="genres[]" multiple="multiple" id="genres" style="width: 100%">
                                            <option disabled="disabled">Choose genres</option>
                                            @foreach($genres as $genre)
                                                <option value="{{ $genre->id }}"
                                                        @if(isset($this->genresSelected[$genre->id])) selected="selected" @endif >{{ $genre->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                <li class="mt-4">
                                    <label class="label">Platforme</label>
                                    <div class="control" wire:ignore>
                                        <select name="platforms[]" multiple="multiple" id="platforms"
                                                style="width: 100%">
                                            <option disabled="disabled">Choose platforms</option>
                                            @foreach($platforms as $platformSelection)
                                                <option
                                                    value="{{ $platformSelection->id }}"
                                                    @if(isset($this->platformsSelected[$platformSelection->id])) selected="selected" @endif >{{ $platformSelection->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                <li class="mt-4">
                                    <label class="label">Game mode</label>
                                    <div class="control" wire:ignore>
                                        <select name="gameModes[]" multiple="multiple" id="gameModes"
                                                style="width: 100%">
                                            <option disabled="disabled">Choose game modes</option>
                                            @foreach($gameModes as $gameMode)
                                                <option
                                                    value="{{ $gameMode->id }}"
                                                    @if(isset($this->gameModesSelected[$gameMode->id])) selected="selected" @endif>{{ $gameMode->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                <li class="mt-4">
                                    <label class="label">Links</label>
                                    <div class="columns is-gapless mb-1">
                                        <div class="column is-10">
                                            <input class="input is-small" type="text" wire:model="newLinkValues.0.value"
                                                   name="links[]">
                                        </div>
                                        <div class="column is-1">
                                            @if (count($newLinks) == 0)
                                                <span class="icon has-text-info is-clickable"
                                                      wire:click="addLink">
                                             <i class="fas fa-plus-circle"></i>
                                         </span>
                                            @endif
                                        </div>
                                    </div>
                                    @foreach($newLinks as $k => $link)
                                        @include('frontend.createGame.add-links', ['position' => $k])
                                    @endforeach
                                </li>
                                <li class="mt-4">
                                    <label class="label">Produit par</label>
                                    <div class="columns is-gapless mb-2">
                                        <div class="column is-10">
                                            <div class="field has-addons">
                                                <div class="control">
                                                    <input class="input is-small" type="text"
                                                           wire:model="newProductorValues.0.value" name="productors[0]">
                                                </div>
                                                <a class="button @if(isset($linkables[0]) && $linkables[0]) has-text-info @else has-text-light @endif is-small"
                                                   wire:click="linkable(0)">
                                                    <i class="fas fa-external-link-alt "></i>
                                                </a>
                                                @if(isset($linkables[0]) && $linkables[0]) <input type="hidden"
                                                                                                  name="productor_links[0]">  @endif
                                            </div>
                                        </div>
                                        <div class="column is-1">
                                            @if (count($newProductors) == 0)
                                                <span class="icon has-text-info is-clickable"
                                                      wire:click="addProductor">
                                              <i class="fas fa-plus-circle"></i>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @foreach($newProductors as $k => $productor)
                                        @include('frontend.createGame.add-productors', ['position' => $k])
                                    @endforeach
                                </li>

                                <li>
                                    <button type="submit" class="button is-link is-light">Save</button>
                                    <div class="is-pulled-right pt-5">
                                        <label for="published"> Publier</label>
                                        <input class="checkbox" type="checkbox" name="published">
                                    </div>
                                </li>
                            </ul>
                        </aside>
                    </div>
                </div>
                <!-- END FORM -->

                <div class="column">
                    <div class="box mt-3">
                        <div class="columns">
                            <div class="column ">
                                <figure class="image static shadow-2xl">
                                    <img
                                        src="{{ Str::of(isset($game['cover']) ? $game['cover']['url'] : '')->replace('thumb', 'screenshot_big')  }}">
                                </figure>
                            </div>
                            <div class="column ">
                                <div class="column is-full p-0">
                                    <span class="title is-3">{{ $title }}</span>
                                    <hr class="dropdown-divider">
                                </div>
                                <div class="columns mb-0">
                                    <div class="column is-full">
                                        <p class="mb-2">
                                            <b>{{ Str::ucFirst(__('frontend.first_release_date'))  }} :</b>
                                            {{ $dateRelease }}
                                        </p>
                                        <p class="mb-2">
                                            <b>{{ Str::ucFirst(Str::plural(__('frontend.genre'), count($genresSelected) === 0 ? 1 : count($genresSelected))) }}
                                                : </b>
                                            <span class="text-gray-900 leading-none">
                                       {{ implode(', ', $genresSelected) }}
                                    </span>
                                        </p>
                                        <p class="mb-2">
                                            <b>{{ Str::ucFirst(Str::plural(__('frontend.platform'), count($platformsSelected) === 0 ? 1 : count($platformsSelected))) }}
                                                :</b>
                                            <span class="text-gray-900 leading-none">
                                            {{ implode(', ', $platformsSelected) }}
                                        </span>
                                        </p>
                                        <p class="mb-2">
                                            <b>{{ Str::ucFirst(Str::plural(__('frontend.theme'), count($themesSelected ) === 0 ? 1 : count($themesSelected ))) }}
                                                : </b>
                                            <span class="text-gray-900 leading-none">
                                             {{ implode(', ', $themesSelected ) }}
                                        </span>
                                        <p class="mb-2">
                                            <b>Game mode :</b>
                                            <span class="text-gray-900 leading-none">
                                             {{ collect($this->gameModesSelected)->pluck('name')->implode(', ') }}
                                        </span>
                                        </p>
                                        {!! $multiplayer !!}

                                        <div class="mb-2">
                                            <b>Links :</b>
                                            <ul>
                                                @foreach($newLinkValues as $k => $link)
                                                    <li>
                                                        {!! isset($link['value']) ? '<a href='.$link['value'].' target="_blank"> '.$link['value'].' </a><i class="has-text-info is-size-7 fas fa-external-link-alt "></i>' : '' !!}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="mb-2">
                                            <p class="mb-2">
                                                <b>{{ Str::ucFirst(__('frontend.produced_by')) }} :</b>
                                            </p>
                                            <ul>
                                                @foreach($newProductorValues as $k => $productor)
                                                    <li>
                                                        @if(isset($linkables[$k]) && $linkables[$k])
                                                            {!! isset($productor['value']) && !empty($productor['value']) ? '<a href='.$productor['value'].' target="_blank"> '.$productor['value'].' </a> <i class="has-text-info is-size-7 fas fa-external-link-alt "></i>' : ''; !!}
                                                        @else
                                                            {{ $productor['value'] }}
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('js')
    <script>
        $(document).ready(() => {
            $('select').select2();

            $.fn.datepicker.languages['fr'] = {format: 'dd/mm/yyyy'};
            $.fn.datepicker.languages['en'] = {format: 'mm/dd/yyyy'};

            let date = null;
            @if ($dateRelease)
                date = new Date({{ Str::of($dateRelease)->split('/-/')->get(0) }}, {{ Str::of($dateRelease)->split('/-/')->get(1)-1}}, {{ Str::of($dateRelease)->split('/-/')->get(2)}});
            @endif

            $('#datepicker').datepicker(
                {
                    language: '{{ App::getLocale() }}',
                    autoHide: true,
                    autoPick: true,
                    date: date
                }
            );
        });

        // Select
        $(document).on('select2:select', function (e) {
            if (e.target.id === 'platforms') {
                Livewire.emit('selectedPlatform', e.params.data.id);
            } else if (e.target.id === 'genres') {
                Livewire.emit('selectedGenre', e.params.data.id);
            } else if (e.target.id === 'gameModes') {
                Livewire.emit('selectedGameMode', e.params.data.id);
            } else if (e.target.id === 'themes') {
                Livewire.emit('selectedTheme', e.params.data.id);
            }
        });

        // Unselect
        $(document).on('select2:unselect', function (e) {
            if (e.target.id === 'platforms') {
                Livewire.emit('unSelectedPlatform', e.params.data.id);
            } else if (e.target.id === 'genres') {
                Livewire.emit('unSelectedGenre', e.params.data.id);
            } else if (e.target.id === 'gameModes') {
                Livewire.emit('unSelectedGameMode', e.params.data.id);
            } else if (e.target.id === 'themes') {
                Livewire.emit('unSelectedTheme', e.params.data.id);
            }
        });

        $(document).on('change', '#datepicker', function (e) {
            Livewire.emit('selectedDateRelease', e.target.value);
        });
    </script>
@endpush
