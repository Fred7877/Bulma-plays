<div>
    <form method="post" action="{{ route('comments.user.update', ['comment' => $comment]) }}">
        @method('put')
        @csrf
        <div class="columns is-mobile is-centered">
            <div class="column is-10">
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
                                            <a href="{{ route('games.show', ['slug' => $comment->game->slug]) }}">
                                            {{ $comment->game->igdb['name'] }}
                                            </a>
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
                            <hr class="p-0 m-0 mb-3">

                            <div class="row mt-1">
                                    @if($editable)
                                        <textarea class="textarea" wire:model="commentTxt" name="comment"></textarea>
                                    <p class="is-family-secondary is-size-7">
                                        <i>*{{ Str::ucFirst(__('frontend.modification_moderation')) }}</i>
                                    </p>
                                    @else
                                    <p class="is-family-secondary">
                                        {{ $commentTxt }}
                                    </p>
                                @endif
                                <div class="is-pulled-right">
                                    <a wire:click="editable">
                                        {{ Str::ucFirst(__('frontend.edit')) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(optional($comment->moderations->last())->comment !== null)
                    <div class="box mt-3 edit-comment">
                        <h5 class="title is-5 m-0 p-0">{{ __('frontend.message_moderation') }}</h5>
                        <hr class="p-0 m-0 mb-3">
                        <p class="is-family-secondary">
                            {{ $comment->moderations->last()->comment }}
                        </p>
                    </div>
                @endif

                <div class="row">
                    <a href="{{ route('comments.user') }}">
                        <button type="button" class="button is-primary is-small is-pulled-left">{{ Str::ucFirst(__('frontend.return')) }}</button>
                    </a>
                    @if($editable)
                        <button type="submit" class="button is-info is-small is-pulled-right">{{ Str::ucFirst(__('frontend.save')) }}</button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
