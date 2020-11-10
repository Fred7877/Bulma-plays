<nav class="pagination is-centered" role="navigation" aria-label="pagination">

    <button class="button is-primary is-small pagination-previous @if($currentPage == 1) button  is-static @endif"
            wire:click="paginate('-')"
    >

        {{ Str::ucFirst(__('frontend.previous')) }}
    </button>

    <ul class="pagination-list">
        @if($currentPage > ($limit * 10))
            <li>
                <button class="pagination-link has-text-light number-page"
                        wire:click="paginate(null, 1)">
                    1
                </button>
            </li>
            <li>
                <span class="pagination-ellipsis has-text-light">&hellip;</span>
            </li>
        @endif
        @foreach(range($currentPage - $limit, $currentPage) as  $num)

            @if($num == ($currentPage - $limit) && $currentPage > $limit)
                @if($num > ($limit * 10))
                    <li>
                        <button class="pagination-link has-text-light number-page"
                                wire:click="paginate(null, {{ $currentPage - ($limit * 10) }})">{{$currentPage - ($limit * 10)}}</button>
                    </li>
                    <li>
                        <span class="pagination-ellipsis has-text-light">&hellip;</span>
                    </li>
                @endif
                <li>
                    <button
                        class="pagination-link number-page @if($num == $currentPage) button is-static @else has-text-light @endif"
                        wire:click="paginate(null, {{ $num }})">
                        {{$num}}
                    </button>
                </li>
                <li>
                    <span class="pagination-ellipsis has-text-light">&hellip;</span>
                </li>
            @endif

            @if($num > 0 && $num < $currentPage && $currentPage <= $limit)
                <li>
                    <button
                        class="pagination-link  number-page @if($num == $currentPage) button  is-static @else has-text-light @endif"
                        wire:click="paginate(null, {{ $num }})">
                        {{$num}}
                    </button>
                </li>
            @endif
        @endforeach
        @foreach(range($currentPage, $pageCount) as  $num)
            @if($num < ($currentPage + $limit) && $num < $pageCount + 1)
                <li>
                    <button
                        class="pagination-link number-page @if($num == $currentPage || $num == $currentPage - 1) button is-static @else has-text-light @endif"
                        wire:click="paginate(null, {{ $num }})">
                        {{$num}}
                    </button>
                </li>
            @elseif($num == ($currentPage + $limit))
                <li>
                    <span class="pagination-ellipsis has-text-light">&hellip;</span>
                </li>
            @elseif($num == floor($pageCount/2))
                <li>
                    <button class="pagination-link has-text-light number-page"
                            wire:click="paginate(null, {{ $num }})">
                        {{$num}}
                    </button>
                </li>
            @elseif($num == floor($pageCount/2) + 1)
                <li>
                    <span class="pagination-ellipsis has-text-light">&hellip;</span>
                </li>
            @elseif($num == $pageCount)
                <li>
                    <button
                        class="pagination-link @if($num == $currentPage - 1) button is-static @else has-text-light @endif"
                        wire:click="paginate(null, {{ $num }})">
                        {{$num}}
                    </button>
                </li>
            @endif
        @endforeach
    </ul>

    <button class="button is-primary pagination-next is-small @if($currentPage == $pageCount) button  is-static @endif"
            wire:click="paginate('+')"
    >
        {{ Str::ucFirst(__('frontend.next')) }}
    </button>
</nav>
