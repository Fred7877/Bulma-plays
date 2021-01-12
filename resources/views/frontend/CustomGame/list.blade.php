@extends('frontend.main')

@section('content')
    <div class="columns is-mobile is-centered">
        <div class="column is-10">
            <div class="box mt-3 p-2">
                <h5 class="title h5 p-0 m-0">Mes jeux Homemade</h5>
                <hr class="p-0 m-0">
            </div>

            @foreach($customGames as $customGame)
                <a href="{{ route('custom-game.edit', ['custom_game' => $customGame]) }}">
                    <div class="box mt-3 edit-comment">
                        <div class="columns is-mobile">
                            <div class="column">
                                <div class="row is-family-secondary">
                                    <div class="columns">
                                        <div class="column is-narrow">
                                            <p class="is-family-secondary">{{ $customGame->created_at }}</p>
                                        </div>
                                        <div class="column">
                                            <h6 class="title is-6">{{ $customGame->name }}</h6>
                                        </div>
                                        <div class="column p-0 mr-2">
                                            <div class="is-pulled-right">
                                                @if(optional($customGame->moderations->last())->status === null)
                                                    <span class="tag is-light">-</span>
                                                @elseif(!$customGame->moderations->last()->status)
                                                    <span class="tag is-danger">N-OK</span>
                                                @else
                                                    <span class="tag is-success">OK</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="p-0 m-0">
                                <div class="row mt-1">
                                    <p class="is-family-secondary">{{ Str::limit($customGame->summary, 150)  }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection

