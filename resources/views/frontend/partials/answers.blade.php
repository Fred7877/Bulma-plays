@if ($replies->parent_comment_id == $comment->id)
    <div class="border p-3">
        <div class="box p-0">
            @include('frontend.partials.header-comment', ['comment' => $replies, 'backgroundColor' => 'has-background-grey'])
            <div class="mt-2 pl-1 pr-1">
                {{ $replies->comment }}
                @foreach($answers as $answer)
                    @include('frontend.partials.answers', ['replies' => $answer, 'comment' => $replies])
                @endforeach
                <div id="{{$typeDesciption}}_area_answers-answers-{{$replies->id}}"
                     style="display: none" wire:ignore
                     class="mt-5">
                    <div class="box">
                        <div class="is-size-7"> Répondre à la réponse
                            de {{ $replies->user->name }} </div>
                        <div class="field">
                            <div class="control" wire:loading.class="is-loading">
                                <textarea wire:loading.attr="disabled" wire:model.defer="answer"
                                          class="textarea is-small"
                                          name="answer" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <input type="hidden" wire:model="type">
                        <div class="column is-full mb-3">
                            <button type="submit"
                                    class="button is-small is-info is-rounded is-pulled-right"
                                    wire:click="sendAnswer('{{$replies->id}}')">
                                Envoyer
                            </button>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-full">
                        <button type="button"
                                class="button mr-5 mt-5 is-small is-info is-rounded is-pulled-right answers-answers"
                                data-id-comment="{{$replies->id}}">
                            répondre
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
