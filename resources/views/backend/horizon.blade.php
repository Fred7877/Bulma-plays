@extends('backend.main')

@section('content_header')
@stop

@section('content')
    <iframe src="{{ route('horizon.index') }}" height="100%" width="100%">
@endsection
