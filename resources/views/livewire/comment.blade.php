<div>
    @foreach($comments as $comment)
        @if (isset($comment->moderations->last()['status']) && $comment->moderations->last()['status'] === \App\Enums\Moderation::ModerationOk)
            <div class="box p-0">
                <div class="level m-0 has-background-dark has-text-white p-1">
                    <div class="level-left">
                        <div class="is-size-7">
                            Author : {{ $comment->user->name }}
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="is-size-7">
                            Le : {{ $comment->user->created_at }}
                        </div>
                    </div>
                </div>
                <hr class="m-0">
                <div class="mt-2 pl-1 pr-1">
                    {!! nl2br(e($comment->comment)) !!}
                </div>
                @if (isset($comment->answers[0]))
                    <div class="border p-3">
                        <p>Réponse :</p>
                        @foreach($comment->answers as $answers)
                            <div class="border p-3">
                                <div class="columns">
                                    <div class="column is-full">
                                        <div class="is-pulled-left">
                                            {{ $answers->comment }}
                                        </div>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column is-full">
                                        <div class="is-pulled-right">
                                            <a class="is-size-7">répondre </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="columns">
                    <div class="column is-full">
                        <div class="is-pulled-right mt-5 pr-1">
                            <a class="is-size-7">répondre</a>
                        </div>
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
            <button type="submit">Envoyer</button>
        </div>
        @error('comment') <span class="error">{{ $message }}</span> @enderror
    </form>

    <button class="button is-primary is-small mt-2" id="add-{{$typeDesciption}}">
        Laisser un {{$typeDesciption}}
    </button>
</div>

