<div>
    @foreach($comments as $comment)
        <div class="box p-0">
            @include('frontend.partials.header-comment', ['comment' => $comment, 'backgroundColor' => 'has-background-dark'])
            <div class="mt-2 pl-1 pr-1">
                {!! nl2br(e($comment->comment)) !!}
                <div class="columns">
                    <div class="column is-full">
                        <button type="button"
                                class="button mr-5 mt-5 is-small is-info is-rounded is-pulled-right answers-answers"
                                data-id-comment="{{$comment->id}}"
                                data-type="{{$type}}"
                                data-type-txt="{{ \App\Enums\CommentType::fromValue($type)->description }}"
                                data-reply-id="{{$comment->id}}"
                                data-author-name="{{ $comment->user->name }}"
                                data-reply="{{ $comment->comment }}"
                                data-game-id="{{ $game['id'] }}"
                        >
                            répondre
                        </button>
                    </div>
                </div>
            </div>

            {{-- ANSWERS --}}
            <div class="border p-3">
                @foreach($answers as $replies)
                    @include('frontend.partials.answers', ['replies' => $replies, 'comment' => $comment, 'gameId' => $game['id']])
                @endforeach
            </div>
        </div>
    @endforeach

    <button class="button is-primary is-small mt-2 leave-comment" id="add-{{$typeDesciption}}"
            data-id-comment="{{$comment->id}}"
            data-type="{{$type}}"
            data-type-txt="{{ \App\Enums\CommentType::fromValue($type)->description }}"
            data-game-id="{{ $game['id'] }}"
    >
        Laisser un {{$typeDesciption}}
    </button>
</div>
