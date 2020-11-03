<nav class="pagination is-centered" role="navigation" aria-label="pagination">

    <button class="button is-primary pagination-previous"
            @if($currentPage == 1)
            disabled
            @else
            wire:click="paginate('-')"
        @endif
    >
        Previous
    </button>

    <ul class="pagination-list">
        @if($currentPage > ($limit * 10))
            <li>
                <a class="pagination-link has-text-light number-page"
                   data-number-page="1"
                   wire:click="paginate(null, 1)">
                    1
                </a>
            </li>
            <li>
                <span class="pagination-ellipsis has-text-light">&hellip;</span>
            </li>
        @endif
        @foreach(range($currentPage - $limit, $currentPage) as  $num)

            @if($num == ($currentPage - $limit) && $currentPage > $limit)
                @if($num > ($limit * 10))
                    <li>
                        <a class="pagination-link has-text-light number-page"
                           data-number-page="{{ $num }}"
                           wire:click="paginate(null, {{ $currentPage - ($limit * 10) }})">{{$currentPage - ($limit * 10)}}</a>
                    </li>
                    <li>
                        <span class="pagination-ellipsis has-text-light">&hellip;</span>
                    </li>
                @endif
                <li>
                    <a class="pagination-link has-text-light number-page" @if($num == $currentPage) disabled @endif
                    data-number-page="{{ $num }}" wire:click="paginate(null, {{ $num }})">{{$num}}</a>
                </li>
                <li>
                    <span class="pagination-ellipsis has-text-light">&hellip;</span>
                </li>
            @endif

            @if($num > 0 && $num < $currentPage && $currentPage <= $limit)
                <li>
                    <a class="pagination-link has-text-light number-page"
                       @if($num == $currentPage) disabled @else
                       data-number-page="{{ $num }}"
                       wire:click="paginate(null, {{ $num }})" @endif
                    >{{$num}}</a>
                </li>
            @endif
        @endforeach
        @foreach(range($currentPage, $pageCount) as  $num)
            @if($num < ($currentPage + $limit) && $num < $pageCount + 1)
                <li>
                    <a class="pagination-link has-text-light number-page"
                       @if($num == $currentPage || $num == $currentPage - 1) disabled @else
                        wire:click="paginate(null, {{ $num }})" @endif data-number-page="{{ $num }}">{{$num}}</a>
                </li>
            @elseif($num == ($currentPage + $limit))
                <li>
                    <span class="pagination-ellipsis has-text-light">&hellip;</span>
                </li>
            @elseif($num == floor($pageCount/2))
                <li>
                    <a class="pagination-link has-text-light number-page" data-number-page="{{ $num }}"
                       wire:click="paginate(null, {{ $num }})">{{$num}}</a>
                </li>
            @elseif($num == floor($pageCount/2) + 1)
                <li>
                    <span class="pagination-ellipsis has-text-light">&hellip;</span>
                </li>
            @elseif($num == $pageCount)
                <li>
                    <a class="pagination-link has-text-light" @if($num == $currentPage - 1) disabled
                       @else wire:click="paginate(null, {{ $num }})" @endif >{{$num}}</a>
                </li>
            @endif
        @endforeach
    </ul>

    <button class="button is-primary pagination-next"
            @if($currentPage == $pageCount)
            disabled
            @else
            wire:click="paginate('+')"
        @endif
    >
        Previous
    </button>
</nav>
