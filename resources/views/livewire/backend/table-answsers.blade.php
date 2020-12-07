@if (!empty($replies->first()))
    <h4>
        @if(optional($replies->first()->parent)->parent_comment_id !== null)
            <span class="badge badge-pill
    btn-info
    mb-3" wire:click="backRepliesList({{ $replies->first()->parent->parent_comment_id }})"> <i
                    class="fas fa-arrow-circle-left"></i> </span>
        @endif

        Answers - niveau {{ $level }} </h4>
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th>Answers</th>
            <th>Author</th>
            <th>Status</th>
            <th>Nb Answers</th>
            <th>Date</th>
            <th>Modération</th>
        </tr>
        </thead>
        @foreach($replies as $anwsers)
            <tr>
                <td>
                    {{ $anwsers->comment }}
                </td>
                <td>
                    {{ $anwsers->user->name }}
                </td>
                <td>
                    @include('backend.comment.partials.status-moderation', ['comment' => $anwsers])
                </td>
                <td>
                    {{ $comment->where('parent_comment_id', $anwsers->id )->count() }}
                    @if($comment->where('parent_comment_id', $anwsers->id )->count() > 0)
                        <br>
                        <a href="#" class="text-decoration-none" wire:click="showAnwsers({{$anwsers->id}})">voir
                            les réponses</a>
                    @endif
                </td>
                <td>
                    {{ \Carbon\Carbon::createFromTimeString($anwsers->created_at)->format('d/m/Y h:i') }}
                </td>
                <td>
                    <form method="post" action="{{ route('backend.moderation') }}">
                        @csrf
                        @include('backend.comment.partials.btn-moderation', ['comment' => $anwsers, 'game' => $game])
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endif
