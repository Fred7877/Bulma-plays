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
