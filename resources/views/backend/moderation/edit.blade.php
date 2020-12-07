@extends('backend.main')

@section('content_header')
    <h1>Moderation</h1>
@stop

@section('content')
    <livewire:backend.answers-list :game="$game" :comment="$comment"/>
@endsection
