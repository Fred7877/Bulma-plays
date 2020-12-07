<div>
    @foreach($comments as $comment)
        @if (isset($comment->moderations->last()['status']) &&
            $comment->moderations->last()['status'] === \App\Enums\Moderation::ModerationOk &&
            $comment['parent_comment_id'] === null)
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
                <div class="border p-3">
                    <!-- ANSWERS -->
                    @if(!$comment->where('parent_comment_id', $comment->id)->get()->isEmpty() &&
                                            !$comment->where('parent_comment_id', $comment->id)->whereHas('moderations', function(Illuminate\Database\Eloquent\Builder $query){
                                                  return $query->where('status', \App\Enums\Moderation::ModerationOk);
                                            })->get()->isEmpty())
                        <p>Réponse :</p>
                        @foreach($comment->where('parent_comment_id', $comment->id)->get() as $answers)
                            @if(isset($answers->moderations->last()['status']) && $answers->moderations->last()['status'] === \App\Enums\Moderation::ModerationOk)
                                @include('frontend.partials.answers', ['comment' => $answers])
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="columns" wire:ignore>
                    <div class="column is-full">
                        <button type="button"
                                class="button mr-5 mt-5 is-small is-info is-rounded is-pulled-right answer-{{$typeDesciption}}"
                                data-id-comment="{{$comment->id}}">
                            répondre
                        </button>
                    </div>
                </div>
            </div>
        @endif
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
