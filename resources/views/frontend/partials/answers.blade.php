@if ($replies->parent_comment_id == $comment->id)
    <div class="border p-3">
        <div class="box p-0">
            @include('frontend.partials.header-comment', ['comment' => $replies, 'backgroundColor' => 'has-background-grey'])
            <div class="mt-2 pl-1 pr-1 box-reply">
                {!! nl2br(e($replies->comment)) !!}
                @foreach($answers as $answer)
                    @include('frontend.partials.answers', ['replies' => $answer, 'comment' => $replies])
                @endforeach
                <div class="columns">
                    <div class="column is-full">
                        <button type="button"
                                class="button mr-5 mt-5 is-small is-info is-rounded is-pulled-right answers-answers"
                                data-id-comment="{{$replies->id}}"
                                data-type="{{$type}}"
                                data-type-txt="{{ \App\Enums\CommentType::fromValue($type)->description }}"
                                data-reply-id="{{$replies->id}}"
                                data-author-name="{{ $replies->user->name }}"
                                data-reply="{{ $replies->comment }}"
                                data-game-id="{{ $gameId }}"
                        >
                            répondre
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
