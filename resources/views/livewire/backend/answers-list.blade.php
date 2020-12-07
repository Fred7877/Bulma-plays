<div>
    <div class="row">
        <div class="col-6">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th scope="col">TITLE</th>
                    <th scope="col">TYPE</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">Langue</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><h4><span class="badge badge-secondary">{{ optional($game)->igdb['name'] ?? '-' }}</span></h4>
                    </td>
                    <td>
                        <h4><span
                                class="badge badge-pill badge-secondary">{{ Str::UcFirst(\App\Enums\CommentType::fromValue($comment->type)->description) }}</span>
                        </h4>
                        <form method="post" action="{{ route('comments.update', $comment) }}">
                            @csrf
                            @method('patch')
                            <button type="submit" class="btn btn-danger mt-2" id="btn-moderation-nok">
                                Switch Type
                            </button>
                            <input type="hidden" name="type" id="type" value="{{ $comment->type }}">
                            <input type="hidden" name="game_slug" id="game_slug"
                                   value="{{ optional($game)['slug'] ?? '' }}">
                        </form>
                    </td>
                    <td>
                        @include('backend.comment.partials.status-moderation', ['comment' => $comment])
                    </td>
                    <td>
                        <div style="width:16px">
                            {!! getFlag($comment->language, '', true, 64) !!}
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <form method="post" action="{{ route('backend.moderation') }}">
                @csrf
                <div class="row">
                    <div class="col-11">
                        <div class="card bg-dark">
                            <div class="card-body">
                                {!! nl2br(e($comment->comment)) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-1">
                        @include('backend.comment.partials.btn-moderation', ['comment' => $comment, 'game' => $game])
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            @include('livewire.backend.table-answsers', ['replies' => $replies, 'level' => $level])
        </div>
    </div>
</div>
