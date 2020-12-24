@extends('frontend.createGame.main')

@section('content')
    <livewire:create-game
        :platforms="$platforms"
        :genres="$genres"
        :gameModes="$gameModes"
        :themes="$themes"
        :customGame="$customGame"
    />
@endsection

