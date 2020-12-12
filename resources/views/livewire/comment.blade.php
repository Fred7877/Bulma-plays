<div>
    @foreach($comments as $comment)
        <div class="box p-0 pb-2">
            @include('frontend.partials.header-comment', ['comment' => $comment, 'backgroundColor' => 'has-background-dark'])
            <div class="mt-2 pl-2 pr-2 is-size-7">
                {!! nl2br(e($comment->comment)) !!}
                <div class="columns">
                    <div class="column is-full">

                        <button type="button"
                                class="button mr-4 mt-2 is-small is-info is-rounded is-pulled-right replies-replies is-size-7"
                                data-id-comment="{{$comment->id}}"
                                data-type="{{$type}}"
                                data-type-txt="{{ \App\Enums\CommentType::fromValue($type)->description }}"
                                data-reply-id="{{$comment->id}}"
                                data-author-name="{{ $comment->user->name }}"
                                data-reply="{{ $comment->comment }}"
                                data-game-id="{{ $game['id'] }}"
                        >
                            {{ __('frontend.reply') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- ANSWERS --}}
            <div class="border">
                @foreach($replies as $reply)
                    @include('frontend.partials.replies', ['reply' => $reply, 'comment' => $comment, 'gameId' => $game['id'], 'replies' => $replies])
                @endforeach
            </div>
        </div>
    @endforeach
    <button class="button is-primary is-small mt-2 leave-comment" id="add-{{$typeDescription}}"
            data-type="{{$type}}"
            data-type-txt="{{ \App\Enums\CommentType::fromValue($type)->description }}"
            data-game-id="{{ $game['id'] }}"
            data-lang="{{ App::getLocale() }}"

    >
        {{ __('frontend.leave_a') }} {{ \App\Enums\CommentType::getDescription(\App\Enums\CommentType::fromKey(Str::UcFirst($typeDescription)))}}
    </button>

</div>
