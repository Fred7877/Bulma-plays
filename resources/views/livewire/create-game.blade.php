<div>
    <div class="mt-3">
        <div class="columns">
            <div class="column is-narrow">
                <aside class="menu">
                    <p class="menu-label">
                        Références
                    </p>
                    <ul class="menu-list">
                        <li>
                            <div class="field">
                                <label class="label">Date première version</label>
                                <div class="control">
                                    <input class="input is-small" id="datepicker">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="field mt-4">
                                <label class="label">Genre</label>
                                <div class="control" wire:ignore>
                                    <select name="genres[]" multiple="multiple">
                                        <option disabled="disabled">Choose genres</option>
                                        <option value="all">all</option>
                                        @foreach(\App\Models\Genre::all() as $genre)
                                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="field mt-4">
                                <label class="label">Platforme</label>
                                <div class="control" wire:ignore>
                                    <select name="platforms[]" multiple="multiple" id="platforms">
                                        <option disabled="disabled">Choose platforms</option>
                                        <option value="all">all</option>
                                        @foreach($platforms as $platformSelection)
                                            <option
                                                value="{{ $platformSelection->id }}">{{ wordwrap($platformSelection->name, 20, "\n", true) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </li>
                    </ul>
                </aside>
            </div>

            <div class="column has-background-light">
                content

                {{ $dateRelease }}

                <div class="column">
                    <div class="column is-full p-0">
                        <span class="title is-3"></span>
                        <hr class="dropdown-divider">
                    </div>
                    <div class="columns mb-0">
                        <div class="column ">
                            <p>
                                <b>{{ Str::ucFirst(__('frontend.first_release_date'))  }} :</b>
                                {{ $dateRelease }}
                            </p>
                            <p>
                                <span class="text-gray-900 leading-none"> </span>
                                <span class="text-gray-900 leading-none"> </span>
                            </p>
                            <p>
                                    <span class="text-gray-900 leading-none">
                                </span>
                            </p>
                            <b>{{ Str::ucFirst(Str::plural(__('frontend.platform'), count($platformsSelected))) }} :</b>
                            {{ implode(', ', $platformsSelected) }}
                            <p>
                                <b>Game mode :</b>
                                <span class="text-gray-900 leading-none">
                                </span>
                            </p>
                            <p>
                                <b>Mode multijoueur :</b>
                            <p>
                            <ul>
                            </ul>
                            <p>
                                    <span class="text-gray-900 leading-none"></span>
                            </p>
                            <p>
                                    <span class="text-gray-900 leading-none"></span>
                            </p>
                        </div>
                        <div class="column is-half">
                            <div class="columns">

                                <div class="column is-2">
                                    <figure class="image is-48x48">

                                    </figure>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">

                            <b>Links :</b>
                            <ul>

                                <li class="text-gray-900 leading-none">

                                            <span class="icon is-small has-text-info">
                                             <i class="fas fa-external-link-alt "></i>
                                        </span>
                                </li>

                            </ul>

                            <div class="columns is-mobile">
                                <div class="column">

                                    <div class="mt-2">
                                        <b>{{ Str::ucFirst(__('frontend.produced_by')) }} :</b>
                                        <ul>

                                            <li class="text-gray-900 leading-none">

                                                        <span class="icon is-small has-text-info">
                                             <i class="fas fa-external-link-alt "></i>
                                        </span>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                                <div class="column">
                                    <div
                                        class="mt-3 mr-3 is-pulled-right rounded-full is-rounded">
                                        <div class="columns">
                                            <div
                                                class="column has-text-centered has-background-primary is-rounded has-text-white p-4 "
                                                style="border-radius: 100%;">

                                                <hr class="dropdown-divider m-0 has-text-centered">
                                                <span class=" is-size-7">

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(document).ready(() => {
            $('select').select2();
            $('#datepicker').datepicker(
                {
                    language: 'en-GB'
                }
            );
        });

        $('#platforms').on('select2:select', function(e){
            console.log(e.params.data.id);
            if(e.params.data.text === 'all' ){
                $("#platforms > option").attr('disabled','disabled');
            }
            Livewire.emit('selectedPlatform', e.params.data.id);
        });

        $('#platforms').on('select2:unselect', function(e){
            if(e.params.data.text === 'all' ){
                $("#platforms > option").removeAttr('disabled');
            }
            console.log(e.params.data.id);
            Livewire.emit('unSelectedPlatform', e.params.data.id);
        });

        $(document).on('change', '#datepicker', function (e) {
            Livewire.emit('selectedDateRelease', e.target.value);
        });
    </script>
@endpush
