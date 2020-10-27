<div>
    <div class="block block-filters pl-5 pt-5 rounded-b-lg pb-3" id="block-filters">
        <div class="columns is-gapless">
            <div class="column ">
                <div class="dropdown dropdown-filter">
                    <div class="dropdown-trigger">
                        <button class="button" aria-haspopup="true" aria-controls="dropdown-menu3"
                                id="filter-nintendo">
                            <span>Plate-forme</span>
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
                                <option value="">Choisir une platform</option>
                                @foreach(collect($platformNintendo)->sortBy('name')->toArray() as $platform1)
                                    <option value="{{ $platform1['slug'] }}">{{ $platform1['name'] }}</option>
                                @endforeach
                            </select>
                            <hr class="dropdown-divider">
                            <label for="platforms">PlayStation :</label>
                            <select class="input is-small" id="platformPlaystation" name="platformPlaystation"
                                    wire:model="platform">
                                <option value="">Choisir une platform</option>
                                @foreach(collect($platformPlaystation)->sortBy('name')->toArray() as $platform1)
                                    <option value="{{ $platform1['slug'] }}">{{ $platform1['name'] }}</option>
                                @endforeach
                            </select>
                            <hr class="dropdown-divider">
                            <label for="platforms">VR :</label>
                            <select class="input is-small" id="platformOculus" name="platformOculus"
                                    wire:model="platform">
                                <option value="">Choisir une platform</option>
                                @foreach(collect($platformOculus)->sortBy('name')->toArray() as $platform1)
                                    <option value="{{ $platform1['slug'] }}">{{ $platform1['name'] }}</option>
                                @endforeach
                            </select>
                            <hr class="dropdown-divider">
                            <label for="platforms">Autres Platforms :</label>
                            <select class="input is-small" id="platforms" name="platforms" wire:model="platform">
                                <option value="">Choisir une platform</option>
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

            <div class="column">
                <div class="dropdown dropdown-genre">
                    <div class="dropdown-trigger">
                        <button class="button" aria-haspopup="true" aria-controls="dropdown-menu3"
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
                                <option value="">Choisir un genre</option>
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

            <div class="column">
                <div class="dropdown dropdown-sort">
                    <div class="dropdown-trigger">
                        <button class="button" aria-haspopup="true" aria-controls="dropdown-menu3" id="filter-sort">
                            <span>Trier</span>
                            <span class="icon is-small">
                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                              </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu3" role="menu">
                        <div class="dropdown-content p-3">
                            <div wire:click="$set('sort', 'desc')" class="pointer">Descendant</div>
                            <hr class="dropdown-divider">
                            <div wire:click="$set('sort', 'asc')" class="pointer">Ascendant</div>
                        </div>
                    </div>
                </div>
                <div class="has-text-primary">
                    {{ Str::ucFirst($sortName) }}
                </div>
            </div>
            <div class="column is-2 mr-5">
                <input class="input" type="text" id="searching" placeholder="Search" name="searching"
                       wire:model.debounce.500ms="search">
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            document.getElementById("filter-nintendo").addEventListener("click", function () {
                var element = document.querySelector(".dropdown-filter");
                element.classList.toggle("is-active");
            });

            document.getElementById("filter-sort").addEventListener("click", function () {
                var element = document.querySelector(".dropdown-sort");
                element.classList.toggle("is-active");
            });

            document.getElementById("filter-genre").addEventListener("click", function () {
                var element = document.querySelector(".dropdown-genre");
                element.classList.toggle("is-active");
            });
        });
    </script>
@endpush
