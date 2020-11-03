<div>
    <div class="block block-filters pl-5 pt-5 rounded-b-lg pb-3" id="block-filters">
        <div class="columns is-multiline is-mobile">
            <div class="column is-narrow">
                <div class="dropdown dropdown-filter">
                    <div class="dropdown-trigger">
                        <button class="button filter" aria-haspopup="true" aria-controls="dropdown-menu3"
                                id="filter-nintendo">
                            <span>{{ Str::Ucfirst(__('frontend.platform')) }}</span>
                            <span class="icon is-small">
                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                              </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu3" role="menu">
                        <div class="dropdown-content p-3">
                            <label for="platforms">Nintendo :</label>
                            <select class="input is-small" id="platformMostPopular" name="platformMostPopular"
                                    wire:model="platform">
                                <option value="">{{ Str::Ucfirst(__('frontend.choose')) }}</option>
                                @foreach(collect($platformNintendo)->sortBy('name')->toArray() as $platform1)
                                    <option value="{{ $platform1['slug'] }}">{{ $platform1['name'] }}</option>
                                @endforeach
                            </select>
                            <hr class="dropdown-divider">
                            <label for="platforms">PlayStation :</label>
                            <select class="input is-small" id="platformPlaystation" name="platformPlaystation"
                                    wire:model="platform">
                                <option value="">{{ Str::Ucfirst(__('frontend.choose')) }}</option>
                                @foreach(collect($platformPlaystation)->sortBy('name')->toArray() as $platform1)
                                    <option value="{{ $platform1['slug'] }}">{{ $platform1['name'] }}</option>
                                @endforeach
                            </select>
                            <hr class="dropdown-divider">
                            <label for="platforms">VR :</label>
                            <select class="input is-small" id="platformOculus" name="platformOculus"
                                    wire:model="platform">
                                <option value="">{{ Str::Ucfirst(__('frontend.choose')) }}</option>
                                @foreach(collect($platformOculus)->sortBy('name')->toArray() as $platform1)
                                    <option value="{{ $platform1['slug'] }}">{{ $platform1['name'] }}</option>
                                @endforeach
                            </select>
                            <hr class="dropdown-divider">
                            <label for="platforms">{{ Str::Ucfirst(__('frontend.others-platform')) }}</label>
                            <select class="input is-small" id="platforms" name="platforms" wire:model="platform">
                                <option value="">{{ Str::Ucfirst(__('frontend.choose')) }}</option>
                                @foreach(collect($Othersplatforms)->sortBy('name')->toArray() as $platform1)
                                    <option value="{{ $platform1['slug'] }}">{{ $platform1['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="has-text-primary">
                    {{ $platformName  }}
                </div>
            </div>

            <div class="column is-narrow">
                <div class="dropdown dropdown-genre">
                    <div class="dropdown-trigger">
                        <button class="button filter" aria-haspopup="true" aria-controls="dropdown-menu3"
                                id="filter-genre">
                            <span>Genre</span>
                            <span class="icon is-small">
                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                              </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu3" role="menu">
                        <div class="dropdown-content p-3">
                            <select class="input is-small" id="genres" name="genres" wire:model="genre">
                                <option value="">{{ Str::Ucfirst(__('frontend.choose_genre')) }}</option>
                                @foreach(collect($genres)->sortBy('name')->toArray() as $genre)
                                    <option value="{{ $genre['slug'] }}">{{ Str::ucFirst($genre['name']) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="has-text-primary">
                    {{ $genreName }}
                </div>
            </div>

            <div class="column is-narrow">
                <div class="dropdown dropdown-sort">
                    <div class="dropdown-trigger">
                        <button class="button filter" aria-haspopup="true" aria-controls="dropdown-menu3"
                                id="filter-sort">
                            <span>{{ Str::Ucfirst(__('frontend.sort')) }}</span>
                            <span class="icon is-small">
                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                              </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu3" role="menu">
                        <div class="dropdown-content p-3">
                            <div wire:click="$set('sort', 'desc')" class="pointer">{{ Str::Ucfirst(__('frontend.descending')) }}</div>
                            <hr class="dropdown-divider">
                            <div wire:click="$set('sort', 'asc')" class="pointer">{{ Str::Ucfirst(__('frontend.ascending')) }}</div>
                        </div>
                    </div>
                </div>
                <div class="has-text-primary">
                    {{ Str::ucFirst($sortName) }}
                </div>
            </div>
            <div class="is-divider-vertical" data-content="OR"></div>
            <div class="column is-2 mr-5">
                <input class="input" type="text" id="searching" placeholder="{{ Str::Ucfirst(__('frontend.research')) }}" name="searching"
                       wire:model.debounce.500ms="search">
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {

            document.body.addEventListener("mouseup", function (e) {
                if (document.body.contains(document.querySelector(".is-active")) && e.target.tagName !== 'SELECT') {
                    document.querySelector(".is-active").classList.remove('is-active');
                }
            });

            document.querySelectorAll('[id^=filter-]').forEach((e) => {
                e.addEventListener("click", function () {
                    e.closest('.dropdown').classList.toggle('is-active');
                });
            });
        });
    </script>
@endpush
