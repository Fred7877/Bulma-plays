@extends('frontend.createGame.main')

<!--
Date première version : 2020-12-17

Genre : Role-playing (RPG)

Plate-forme : PlayStation 5

Game mode : Single player

Thème : Action

Perspective : Third person
-->


@section('content')
    <livewire:create-game :platforms="$platforms" />
@endsection

