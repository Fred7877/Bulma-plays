@if ($reply->parent_comment_id == $comment->id)
    <div class="border p-3 is-size-7 {{ isset($hidden) ? $hidden : '' }}"
         id="reply-to-reply-{{$comment->id}}{{ isset($iteration) ? '-'.$iteration : '' }}">
        <div class="box p-0">
            @include('frontend.partials.header-comment', ['comment' => $reply, 'backgroundColor' => 'has-background-grey'])
            <div class="mt-2 pl-2 pr-2 box-reply ">
                {!! nl2br(e($reply->comment)) !!}
                @foreach($replies as $reply1)
                    @include('frontend.partials.replies', ['reply' => $reply1, 'comment' => $reply, 'hidden' => 'is-hidden', 'iteration' => $loop->iteration])
                @endforeach

                <div class="level">
                    <div class="level-left">
                        @if ($replies->where('parent_comment_id', $reply->id)->count() > 0)
                            <div class="btn-show-replies">
                                <a class="is-pulled-left has-text-info show-replies"
                                   data-comment-id="{{$reply->id}}"> {{ __('frontend.show_replies') }}
                                    ({{ $replies->where('parent_comment_id', $reply->id)->count() }}) </a>
                            </div>
                            <div class="btn-hide-replies is-hidden">
                                <a class="is-pulled-left has-text-info hide-replies"
                                   data-comment-id="{{$reply->id}}">{{ __('frontend.hide_replies') }}
                                    ({{ $replies->where('parent_comment_id', $reply->id)->count() }}) </a>
                            </div>
                        @endif
                    </div>

                    <div class="level-right">
                        <div class="is-pulled-right">
                            <button type="button"
                                    class="button mb-3 is-small is-info is-rounded  replies-replies"
                                    data-id-comment="{{$reply->id}}"
                                    data-type="{{$type}}"
                                    data-type-txt="{{ \App\Enums\CommentType::fromValue($type)->description }}"
                                    data-reply-id="{{$reply->id}}"
                                    data-author-name="{{ $reply->user->name }}"
                                    data-reply="{{ $reply->comment }}"
                                    data-game-id="{{ $gameId }}"
                                    data-language="{{ App::getLocale() }}"
                            >
                                {{ __('frontend.reply') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
