@extends('backend.main')

@section('content_header')
    <h1>Moderation</h1>
@stop

@section('content')
    <livewire:backend.replies-list :game="$game" :comment="$comment"/>
@endsection
