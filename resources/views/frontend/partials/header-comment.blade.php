<div class="level m-0 {{ $backgroundColor }} has-text-white p-1">
    <div class="level-left">
        <div class="is-size-7 author">
            Author : {{ $comment->user->name }}
        </div>
    </div>
    <div class="level-right">
        <div class="is-size-7">
            Le : {{ $comment->created_at }}
        </div>
    </div>
</div>
<hr class="m-0">
