<div class="col">
    <form method="post" action="{{ route('backend.moderation') }}">
        @csrf
        <div class="form-row">
            <button type="submit" class="btn btn-success btn-sm" id="btn-moderation-ok">Moderation OK</button>
        </div>
        <input type="hidden" name="status" id="status_comment_{{ $comment->id }}"
               value="{{ \App\Enums\Moderation::ModerationOk }}">
        <input type="hidden" name="comment_id" id="comment_{{ $comment->id }}" value="{{ $comment->id }}">
        <input type="hidden" name="game_slug" id="game_slug_{{ $comment->id }}"
               value="{{ optional($game)['slug'] ?? '' }}">
    </form>

    <form method="post" action="{{ route('backend.moderation') }}">
        @csrf
        <div class="form-row">
            <button type="submit" class="btn btn-danger mt-2 btn-sm" id="btn-moderation-nok">Moderation NOK
            </button>
        </div>
        <input type="hidden" name="status" id="status_comment_{{ $comment->id }}"
               value="{{ \App\Enums\Moderation::ModerationNOk }}">
        <input type="hidden" name="comment_id" id="comment_{{ $comment->id }}" value="{{ $comment->id }}">
        <input type="hidden" name="game_slug" id="game_slug_{{ $comment->id }}"
               value="{{ optional($game)['slug'] ?? '' }}">
    </form>
</div>
