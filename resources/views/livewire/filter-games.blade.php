<div>
    <div class="block block-filters pl-5 pt-5 rounded-b-lg pb-3">
        <div class="field is-horizontal">
            <div class="mr-6">
                <div class="dropdown dropdown-filter">
                    <div class="dropdown-trigger">
                        <button class="button" aria-haspopup="true" aria-controls="dropdown-menu3" id="filter-nintendo">
                            <span>Filtre plate-forme</span>
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
            </div>

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
                    <div class="dropdown-content">
                        <div wire:click="$set('sort', 'desc')" class="pointer">Descendant</div>
                        <hr class="dropdown-divider">
                        <div wire:click="$set('sort', 'asc')" class="pointer">Ascendant</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column is-2">
                <div class="has-text-primary">
                    {{ Str::of($platformName)->limit(19)  }}
                </div>
            </div>
            <div class="column ml-1">
                <div class="has-text-primary">
                    {{ $sortName }}
                </div>
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
        });
    </script>
@endpush
