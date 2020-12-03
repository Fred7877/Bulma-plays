@extends('backend.main')

@section('content_header')
    <h1>Moderation</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-6">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th scope="col">TITLE</th>
                    <th scope="col">TYPE</th>
                    <th scope="col">STATUS</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><h4><span class="badge badge-secondary">{{ $game->igdb['name'] }}</span></h4></td>
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
                            <input type="hidden" name="game_slug" id="game_slug" value="{{ $game['slug'] }}">
                        </form>
                    </td>
                    <td>
                        <h4>
                            <span class="badge badge-pill
            @if($comment->moderations->first() === null)
                                btn-primary
                                    @elseif((int) $comment->moderations->last()->status === \App\Enums\Moderation::ModerationNOk)
                                btn-danger
                                    @else
                                btn-success
                                    @endif
                                mb-3">
                            Status
                            : @if($comment->moderations->first() === null) {{ '-' }}  @else {{ \App\Enums\Moderation::getDescription($comment->moderations->last()->status) }} @endif
                            </span>
                        </h4>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form method="post" action="{{ route('backend.moderation') }}">
        @csrf
        <div class="row">
            <div class="col">
                <div class="card bg-dark">
                    <div class="card-body">
                        {!! nl2br(e($comment->comment)) !!}
                    </div>

                </div>
            </div>
            <div class="col">
                <div class="form-row">
                    <button type="submit" class="btn btn-success" id="btn-moderation-ok">Moderation OK</button>
                </div>
                <div class="form-row">
                    <button type="submit" class="btn btn-danger mt-2" id="btn-moderation-nok">Moderation NOK
                    </button>
                </div>

            </div>
        </div>
        <input type="hidden" name="status" id="status" value="{{ \App\Enums\Moderation::ModerationNOk }}">
        <input type="hidden" name="comment_id" id="comment_id" value="{{ $comment->id }}">
        <input type="hidden" name="game_slug" id="game_slug" value="{{ $game['slug'] }}">
    </form>

@endsection

@push('js')
    <script>
        $(document).ready(() => {
            $('#btn-moderation-ok').on('click', (e) => {
                $('#status').val({{ \App\Enums\Moderation::ModerationOk }});
            })
        });
    </script>
@endpush
