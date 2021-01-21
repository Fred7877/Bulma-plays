<div>
    <div class="row">
        <div class="col">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th scope="col">TITLE</th>
                    <th scope="col">TYPE</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">Langue</th>
                    <th scope="col">Commentaire modération</th>
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
                    <td>{{ optional($comment->moderations->last())->comment }}</td>
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
                    <div class="col-1 m-0 p-0">
                        @include('backend.comment.partials.btn-moderation', ['comment' => $comment, 'game' => $game])
                    </div>
                </div>
            </form>
            @include('livewire.backend.table-replies', ['replies' => $replies, 'level' => $level])
        </div>
        <div class="col">
            Liste des commentaires en attente de modération pour <b>{{ optional($game)->igdb['name'] ?? '-' }}</b>

            <table class="table table-bordered table-sm">
                <tbody>
                @foreach($waitingModeration as $waitingComment)
                    @if ($waitingComment->id !== $comment->id)
                    <tr>
                        <td>
                            {{ $waitingComment->comment }}
                        </td>
                        <td>
                            @include('backend.comment.partials.status-moderation', ['comment' => $waitingComment])
                        </td>
                        <td>
                            <form method="post" action="{{ route('backend.moderation') }}">
                                @csrf
                                @include('backend.comment.partials.btn-moderation', ['comment' => $waitingComment, 'game' => $game])
                            </form>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#btn-moderation-nok', function (e) {
                let commentId = e.target.dataset.commentId;

                Swal.fire({
                    title: 'Commentaire N-ok',
                    html: `
       <textarea cols='50' rows='5' name='comment'></textarea>
      `,
                    confirmButtonText: 'Save!',
                    onBeforeOpen: function(){
                        $('textarea[name=comment]').val($('#comment_moderation_' + commentId).val())
                    },
                    preConfirm: () => {
                        $('#comment_moderation_' + commentId).val($('textarea[name=comment]').val());
                        $(e.target).toggleClass('btn-danger', $('textarea[name=comment]').val() === '');
                        $(e.target).toggleClass('btn-warning', $('textarea[name=comment]').val() !== '');
                        $('#form_moderation_'+commentId).submit();
                    }
                });
            });
        });
    </script>
@endpush
