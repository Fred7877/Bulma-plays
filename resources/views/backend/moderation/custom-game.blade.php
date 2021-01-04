@extends('backend.main')

@section('content_header')
    <h1>Custom game modération
        @if ($customGame->moderations->last() === null) <span class="badge badge-secondary"> - </span>
        @else
            @if($customGame->moderations->last()->status) <span class="badge badge-success">OK</span> @else <span class="badge badge-danger">N-OK</span>
        @endif
        @endif
    </h1>
@stop

@section('content')
    <div class="container mb-5">
        <div class="mb-5">
            <div class="row">
                <label for="" class="form-label">Publié : &nbsp; </label>
                @if($customGame->publish_date) Oui @else Non @endif
            </div>
            <div class="row">
                <label for="" class="form-label">Title : &nbsp; </label>
                {{ $customGame->name }}
            </div>
            <div class="row">
                <label for="" class="form-label">Date release : &nbsp;</label>
                {{ $customGame->date_release }}
            </div>
            <div class="row">
                <label for="" class="form-label">Thèmes : &nbsp;</label>
                {{ $customGame->themes()->pluck('name')->implode(', ') }}
            </div>
            <div class="row">
                <label for="" class="form-label">Genres : &nbsp;</label>
                {{ $customGame->genres()->pluck('name')->implode(', ') }}
            </div>
            <div class="row">
                <label for="" class="form-label">Plateforme : &nbsp;</label>
                {{ $customGame->platforms()->pluck('name')->implode(', ') }}
            </div>
            <div class="row">
                <label for="" class="form-label">Game modes : &nbsp;</label>
                {{ $customGame->gameModes()->pluck('name')->implode(', ') }}
            </div>
            <div class="row">
                <label for="" class="form-label">Links : &nbsp;</label>
                {{ $customGame->customLinks()->pluck('url')->implode(', ') }}
            </div>
            <div class="row">
                <label for="" class="form-label">Productors : &nbsp;</label>
                {{ $customGame->productors()->pluck('value')->implode(', ') }}
            </div>
            <div class="row">
                <label for="" class="form-label">Synopsis : &nbsp;</label>
                {{ $customGame->synopsis }}
            </div>
            <div class="row">
                <label for="" class="form-label">Screeshots : &nbsp;</label>
            </div>
            <div class="row">
                @foreach($customGame->screenshots as $screenshot)
                    <img class="mr-1 img-thumbnail" style="width:250px"
                         src="{{ Storage::disk('s3')->url($screenshot->path) }}">
                @endforeach
            </div>
            <div class="row mt-3">
                <label for="" class="form-label">Vidéos : &nbsp;</label>
            </div>
            <div class="row">
                @foreach($customGame->videos as $video)
                    <div class="mr-1 img-thumbnail">
                        <video controls width="250">
                            <source src="{{ Storage::disk('s3')->url($video->path) }}">
                        </video>
                    </div>
                @endforeach
            </div>
        </div>
        <form method="post" action="{{ route('custom-games.update', ['custom_game' => $customGame]) }}">
            @csrf
            @method('put')
            <div class="row">
                <div class="columns">
                    <div class="col">
                        <button type="submit" class="btn btn-primary mr-3" name="moderation_ok">Ok</button>
                        <button type="submit" class="btn btn-danger" name="moderation_nok">N-OK</button>
                    </div>
                </div>
                <div class="col">
                    <textarea name="comment" id="" cols="50" rows="5"></textarea>
                </div>
            </div>
        </form>
    </div>
@endsection
