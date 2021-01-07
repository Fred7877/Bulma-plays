<div xmlns:wire="http://www.w3.org/1999/xhtml">
    @if(Session::has('message'))
        <input type="hidden" name="message">
    @endif

    <input type="hidden" name="date_release_custom" value="{{ $dateRelease }}">

    <form method="post" action="{{ $actionForm }}" enctype="multipart/form-data">
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
                                    <label class="label">{{ Str::ucFirst(__('frontend.title')) }}*</label>
                                    <div class="control">
                                        <input class="input is-small @error('title') is-danger @enderror" type="text"
                                               name="title" wire:model.debounce.500ms="title"
                                               autocomplete="off">
                                    </div>
                                    @error('title')
                                    <div
                                        class="mt-1 p-1 is-size-7 has-text-danger has-background-danger-light">{{ $message }}</div> @enderror
                                </li>
                                <li class="mt-4">
                                    <label class="label">{{ Str::ucFirst(__('frontend.presentation_image')) }}</label>

                                    <div class="file has-name is-small">
                                        <label class="file-label">
                                            <input class="file-input @error('imagePresentation') is-danger @enderror"
                                                   type="file" wire:model="imagePresentation"
                                                   value="{{ $imagePresentation }}"
                                                   name="imagePresentation">
                                            <span class="file-cta">
                                              <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                              </span>
                                              <span class="file-label">
                                                {{ Str::ucFirst(__('frontend.choose_file')) }}
                                              </span>
                                            </span>
                                            <span class="file-name">
                                                @if($imagePresentation)
                                                    @if(!is_string($imagePresentation))
                                                        {{ $imagePresentation->getClientOriginalName() }}
                                                    @else
                                                        {{ basename($imagePresentation) }}
                                                    @endif
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                    @error('imagePresentation')
                                    <div
                                        class="mt-1 p-1 is-size-7 has-text-danger has-background-danger-light">{{ $message }}</div> @enderror
                                </li>
                                <li class="mt-4">
                                    <label class="label">{{ Str::ucFirst(__('frontend.first_release_date')) }}</label>
                                    <input class="input is-small" id="datepicker" name="date_release"
                                           value="{{ $dateRelease ?? '' }}"
                                           autocomplete="off">
                                </li>
                                <li class="mt-4">
                                    <label class="label">{{ Str::ucFirst(__('frontend.themes')) }}</label>
                                    <div class="control" wire:ignore>
                                        <select name="themes[]" multiple="multiple" id="themes" style="width: 100%"
                                                class="selector">
                                            <option disabled="disabled">{{ Str::ucFirst(__('frontend.choose_theme')) }}</option>
                                            @foreach($themes as $theme)
                                                <option value="{{ $theme->id }}"
                                                        @if(isset($this->themesSelected[$theme->id])) selected="selected" @endif >{{ $theme->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                <li class="mt-4">
                                    <label class="label">{{ Str::ucFirst(__('frontend.genres')) }}</label>
                                    <div class="control" wire:ignore>
                                        <select name="genres[]" multiple="multiple" id="genres" style="width: 100%"
                                                class="selector">
                                            <option disabled="disabled">{{ Str::ucFirst(__('frontend.choose_genres')) }}</option>
                                            @foreach($genres as $genre)
                                                <option value="{{ $genre->id }}"
                                                        @if(isset($this->genresSelected[$genre->id])) selected="selected" @endif >{{ $genre->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                <li class="mt-4">
                                    <label class="label">{{ Str::ucFirst(__('frontend.platforms')) }}</label>
                                    <div class="control" wire:ignore>
                                        <select name="platforms[]" multiple="multiple" id="platforms"
                                                style="width: 100%" class="selector">
                                            <option disabled="disabled">{{ Str::ucFirst(__('frontend.choose_genres')) }}</option>
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
                                                style="width: 100%" class="selector">
                                            <option disabled="disabled">{{ Str::ucFirst(__('frontend.choose_game_mode')) }}</option>
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
                                                   name="links[0]">
                                        </div>
                                        <div class="column is-1">
                                            @if (isset($newLinkValues[0]) && $newLinkValues[0]['value'] != '' && count($newLinkValues) == 1)
                                                <span class="icon is-small ml-2 has-text-info is-clickable"
                                                      wire:click="addLink">
                                             <i class="fas fa-plus-circle"></i>
                                         </span>
                                            @endif
                                            @if (isset($newLinkValues[0]))
                                                <span class="icon is-small ml-2 has-text-danger is-clickable"
                                                      wire:click="removeLink(0)">
                                                  <i class="fas fa-minus-circle"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @foreach($newLinkValues as $k => $link)
                                        @if($k !== 0)
                                            @include('frontend.CustomGame.add-links', ['position' => $k])
                                        @endif
                                    @endforeach
                                </li>
                                <li class="mt-4">
                                    <label class="label">{{ Str::ucFirst(__('frontend.produced_by')) }}</label>
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
                                            @if (isset($newProductorValues[0]) && $newProductorValues[0]['value'] != '' && count($newProductorValues) == 1)
                                                <span class="icon is-small ml-2 has-text-info is-clickable"
                                                      wire:click="addProductor">
                                              <i class="fas fa-plus-circle"></i>
                                            </span>
                                            @endif
                                            @if (isset($newProductorValues[0]))
                                                <span class="icon is-small ml-2 has-text-danger is-clickable"
                                                      wire:click="removeProductor(0)">
                                                  <i class="fas fa-minus-circle"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @foreach($newProductorValues as $k => $productor)
                                        @if($k !== 0)
                                            @include('frontend.CustomGame.add-productors', ['position' => $k])
                                        @endif
                                    @endforeach
                                </li>

                                <li class="mt-4">
                                    <label class="label" for="synopsis">Synopsis<span
                                            class="is-size-7 {{ $classNumCharSynopsis }}">({{ $numCharSynopsis }}/500)</span></label>
                                    <textarea class="textarea" name="synopsis" id="" cols="30" rows="5"
                                              wire:model="synopsis"></textarea>
                                </li>
                                <li class="mt-4">
                                    <label class="label">Screenshots</label>
                                    <div class="columns is-gapless mb-1">
                                        <div class="column is-10">
                                            <div class="file has-name is-small">
                                                <label class="file-label">
                                                    <input class="file-input" type="file"
                                                           wire:model="newScreenshotValues.0.value"
                                                           name="screenshots[0]"
                                                           value="{{ $newScreenshotValues[0]['value'] ?? '' }}">
                                                    <input type="hidden"
                                                           value="{{ $newScreenshotValues[0]['value'] ?? '' }}"
                                                           name="screenshotsHidden[0]">
                                                    <span class="file-cta">
                                                    <span class="file-icon">
                                                        <i class="fas fa-upload"></i>
                                                      </span>
                                                      <span class="file-label">
                                                        {{ Str::ucFirst(__('frontend.choose_file')) }}
                                                      </span>
                                                    </span>
                                                    <span class="file-name">
                                                        @if(isset($newScreenshotValues[0]))
                                                            @if(!is_string($newScreenshotValues[0]['value']))
                                                                {{ $newScreenshotValues[0]['value']->getClientOriginalName() }}
                                                            @else
                                                                {{ basename($newScreenshotValues[0]['value']) }}
                                                            @endif
                                                        @endif
                                                    </span>
                                                </label>
                                            </div>
                                            @error('newScreenshotValues.0.value')
                                            <div
                                                class="mt-1 p-1 is-size-7 has-text-danger has-background-danger-light">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="column is-1">
                                            @if (isset($newScreenshotValues[0]) && $newScreenshotValues[0]['value'] != '' && count($newScreenshotValues) == 1)
                                                <span class="icon has-text-info is-small ml-2 is-clickable"
                                                      wire:click="addScreenshot">
                                                     <i class="fas fa-plus-circle"></i>
                                                </span>
                                            @endif
                                            @if (isset($newScreenshotValues[0]))
                                                <span class="icon is-small ml-2 has-text-danger is-clickable"
                                                      wire:click="removeScreenshot(0)">
                                                  <i class="fas fa-minus-circle"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @foreach($newScreenshotValues as $k => $screenshot)
                                        @if($k !== 0)
                                            @include('frontend.CustomGame.add-screenshots', ['position' => $k])
                                        @endif
                                    @endforeach
                                </li>
                                <li class="mt-4">
                                    <label class="label">{{ Str::ucFirst(__('frontend.video')) }}</label>
                                    <div class="columns is-gapless mb-1">
                                        <div class="column is-10">
                                            <div class="file has-name is-small">
                                                <label class="file-label">
                                                    <input class="file-input" type="file"
                                                           wire:model="newVideoValues.0.value"
                                                           name="videos[0]"
                                                           value="{{ $newVideoValues[0]['value'] ?? '' }}">
                                                    <input type="hidden"
                                                           value="{{ $newVideoValues[0]['value'] ?? '' }}"
                                                           name="videosHidden[0]">
                                                    <span class="file-cta">
                                                    <span class="file-icon">
                                                        <i class="fas fa-upload"></i>
                                                      </span>
                                                      <span class="file-label">
                                                       {{ Str::ucFirst(__('frontend.choose_file')) }}
                                                      </span>
                                                    </span>
                                                    <span class="file-name">
                                                        @if(isset($newVideoValues[0]))
                                                            @if(!is_string($newVideoValues[0]['value']))
                                                                {{ $newVideoValues[0]['value']->getClientOriginalName() }}
                                                            @else
                                                                {{ basename($newVideoValues[0]['value'] )}}
                                                            @endif
                                                        @endif
                                                    </span>
                                                </label>
                                            </div>
                                            @error('newVideoValues.0.value')
                                            <div
                                                class="mt-1 p-1 is-size-7 has-text-danger has-background-danger-light">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="column is-1">
                                            @if (isset($newVideoValues[0]) && $newVideoValues[0]['value'] != '' && count($newVideoValues) == 1)
                                                <span class="icon has-text-info is-small ml-2 is-clickable"
                                                      wire:click="addVideo">
                                                     <i class="fas fa-plus-circle"></i>
                                                </span>
                                            @endif
                                            @if (isset($newVideoValues[0]))
                                                <span class="icon is-small ml-2 has-text-danger is-clickable"
                                                      wire:click="removeVideo(0)">
                                                  <i class="fas fa-minus-circle"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @foreach($newVideoValues as $k => $video)
                                        @if($k !== 0)
                                            @include('frontend.CustomGame.add-videos', ['position' => $k])
                                        @endif
                                    @endforeach
                                </li>
                                <li class="mt-4">
                                    <button type="submit" class="button is-link is-light">{{ Str::ucFirst(__('frontend.save')) }}</button>
                                    <div class="is-pulled-right pt-5">
                                        <label for="published">{{ Str::ucFirst(__('frontend.publish')) }}</label>
                                        <input class="checkbox" type="checkbox" @if($published) checked="checked" @endif name="published" id="published" wire:model="published">
                                    </div>
                                </li>
                            </ul>
                        </aside>
                    </div>
                </div>
                <!-- END FORM -->

                <div class="column">
                    <div class="box mt-3">
                        <div class="columns is-vcentered">
                            <div class="column ">

                                <div class="is-flex is-justify-content-center ">
                                    <div wire:loading wire:target="imagePresentation"><div class="loader is-loading"></div></div>

                                </div>
                                <figure class="image static" wire:loading.remove
                                        wire:target="imagePresentation">
                                    <img
                                        src="
                                        @if($imagePresentation)
                                        @if(!is_string($imagePresentation))
                                        {{ $imagePresentation->temporaryUrl() }}
                                        @else
                                        {{ asset($imagePresentation) }}
                                        @endif
                                        @endif
                                            ">
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
                                            <b>{{ Str::ucFirst(Str::plural(__('frontend.genres'), count($genresSelected) === 0 ? 1 : count($genresSelected))) }}
                                                : </b>
                                            <span class="text-gray-900 leading-none">
                                       {{ implode(', ', $genresSelected) }}
                                    </span>
                                        </p>
                                        <p class="mb-2">
                                            <b>{{ Str::ucFirst(Str::plural(__('frontend.platforms'), count($platformsSelected) === 0 ? 1 : count($platformsSelected))) }}
                                                :</b>
                                            <span class="text-gray-900 leading-none">
                                            {{ implode(', ', $platformsSelected) }}
                                        </span>
                                        </p>
                                        <p class="mb-2">
                                            <b>{{ Str::ucFirst(Str::plural(__('frontend.themes'), count($themesSelected ) === 0 ? 1 : count($themesSelected ))) }}
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
                                                        {!! isset($link['value']) ? '<a href="'. (Str::contains($link['value'], 'http') ? $link['value'] : 'https://'.$link['value']).'" target="_blank"> '.$link['value'].' </a><i class="has-text-info is-size-7 fas fa-external-link-alt "></i>' : '' !!}
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
                                                            {!! isset($productor['value']) && !empty($productor['value']) ? '<a href="'. (Str::contains($productor['value'], 'http') ? $productor['value'] : 'https://'.$productor['value']).'" target="_blank"> '.$productor['value'].' </a> <i class="has-text-info is-size-7 fas fa-external-link-alt "></i>' : ''; !!}
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

                        @if($synopsis)
                            <hr class="dropdown-divider">
                            <div class="block">
                                <div class="content">
                                    <b>Synopsis :</b>
                                    <p>
                                        {{ $synopsis }}
                                    </p>
                                </div>
                            </div>
                    @endif

                    <!-- SCREENSHOTS -->
                        <div
                            class="box has-background-dark p-4"
                            wire:ignore
                            id="screenshots"
                            @if(!isset($screenshotValues[0])) style="display:none;max-width: 960px"
                            @else style="max-width: 960px" @endif >
                            <div class="owl-carousel owl-theme" id="carousel-screenshot">
                                @if(isset($screenshotValues[0]))
                                    @foreach($screenshotValues as $s => $screenshot)
                                        <a id='single_image-{{ $s }}'
                                           href='{{ $screenshot['value'] }}'>
                                            <img src="{{ $screenshot['value'] }}">
                                            <input type="hidden" name="screenshotsHidden[{{$s}}]"
                                                   value="{{ $screenshot['value'] }}">
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- VIDEOS -->
                        <div
                            class="box has-background-dark p-4"
                            wire:ignore
                            id="videos"
                            @if(!isset($newVideoValues[0])) style="display:none;max-width: 960px"
                            @else style="max-width: 960px" @endif >
                            <div class="owl-carousel owl-theme" id="carousel-video">
                                @if(isset($newVideoValues[0]))
                                    @foreach($newVideoValues as $v => $video)
                                        <video width="320" height="240" controls>
                                            <source src="{{ $video['value'] }}">
                                        </video>
                                        <input type="hidden" name="videosHidden[{{ $v }}]"
                                               value="{{ $video['value'] }}">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('js')
    <script src="/js/custom-game.js"></script>
@endpush
