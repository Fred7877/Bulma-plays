@extends('frontend.main')

@push('css')
<style>
    .edit-comment:hover {
        background-color: hsl(171, 100%, 96%);
    }
</style>
@endpush

@section('content')
    <div class="columns is-mobile is-centered">
        <div class="column is-10">
            <div class="box mt-3 p-2">
                <h5 class="title h5 p-0 m-0">{{ __('frontend.my_comments') }}</h5>
                <hr class="p-0 m-0">
            </div>

            @foreach($comments as $comment)
                <a href="{{ route('comments.user.edit', ['comment' => $comment]) }}">
                    <div class="box mt-3 edit-comment">
                        <div class="columns is-mobile">
                            <div class="column">
                                <div class="row is-family-secondary">
                                    <div class="columns">
                                        <div class="column is-narrow">
                                            <p class="is-family-secondary">{{ $comment->created_at }}</p>
                                        </div>
                                        <div class="column">
                                            <h6 class="title is-6">
                                                {{ $comment->game->igdb['name'] }}
                                            </h6>
                                        </div>
                                        <div class="column p-0 mr-2">
                                            <div class="is-pulled-right">
                                                @if($comment->moderations->last() === null || $comment->moderations->last()->status === null)
                                                    <span class="tag is-light">-</span>
                                                @elseif(!$comment->moderations->last()->status)
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
                                    <p class="is-family-secondary">{{ Str::limit($comment->comment, 150)  }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
