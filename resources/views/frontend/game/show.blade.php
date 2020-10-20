@extends('frontend.main')

@section('content')
<img src="{{ Str::of(isset($game->cover) ? $game->cover->url : '')->replace('thumb', '1080p')  }}">
@stop

