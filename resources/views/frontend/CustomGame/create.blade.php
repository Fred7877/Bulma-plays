@extends('frontend.main')

@section('content')
    <livewire:custom-game :platforms="$platforms" :genres="$genres" :gameModes="$gameModes" :themes="$themes" />
@endsection
