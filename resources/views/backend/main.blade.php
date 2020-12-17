@extends('adminlte::page')
@routes
@section('title', 'Dashboard')
@livewireStyles
@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content_top_nav_right')
    <livewire:backend.scheduler />
@endsection

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')

@stop
@livewireScripts
@section('js')

@stop
