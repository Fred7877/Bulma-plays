<div>
    @foreach($comments as $comment)
        <div class="box p-0">
            @include('frontend.partials.header-comment', ['comment' => $comment, 'backgroundColor' => 'has-background-dark'])
            <div class="mt-2 pl-1 pr-1">
                {!! nl2br(e($comment->comment)) !!}
                <form wire:submit.prevent="sendAnswer">
                    <div id="{{$typeDesciption}}_area_answer-{{$comment->id}}" style="display: none" wire:ignore
                         class="mt-5">
                        <div class="box">
                            <div class="is-size-7"> Répondre au commentaire de {{ $comment->user->name }} </div>
                            <div class="field">
                                <div class="control" wire:loading.class="is-loading">
                                <textarea wire:loading.attr="disabled" wire:model.defer="answer"
                                          class="textarea is-small"
                                          name="answer" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <input type="hidden" wire:model="type">
                            <div class="column is-full mb-3">
                                <button type="submit" class="button is-small is-info is-rounded is-pulled-right"
                                        wire:click="sendAnswer('{{$comment->id}}')">
                                    Envoyer
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('comment') <span class="error">{{ $message }}</span> @enderror
                </form>
            </div>

            {{-- ANSWERS --}}
            <div class="border p-3">
                @foreach($answers as $replies)
                    @include('frontend.partials.answers', ['replies' => $replies, 'comment' => $comment])
                @endforeach
            </div>
        </div>
    @endforeach

    <form wire:submit.prevent="sendComment">
        <div id="{{$typeDesciption}}_area" style="display: none" wire:ignore>
            <div class="field">
                <div class="control" wire:loading.class="is-loading">
                    <textarea wire:loading.attr="disabled" wire:model.defer="comment" class="textarea is-small"
                              name="comment" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
            <input type="hidden" wire:model="type">
            <button type="submit" class="button is-small is-info is-rounded is-pulled-right">Envoyer</button>
        </div>
        @error('comment') <span class="error">{{ $message }}</span> @enderror
    </form>

    <button class="button is-primary is-small mt-2" id="add-{{$typeDesciption}}">
        Laisser un {{$typeDesciption}}
    </button>
</div>
