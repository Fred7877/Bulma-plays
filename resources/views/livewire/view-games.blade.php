<div>
    <livewire:filter-games/>

    <div class="level-item has-text-centered">
        <div wire:loading>
            <div class="loader-wrapper is-active mt-5">
                <div class="loader is-loading"></div>
            </div>
        </div>
    </div>

    <div class="block mt-5">
        <div wire:loading.remove>
            @forelse ($games as $game)
                @include('frontend.partials.card-game', ['game' => $game])
            @empty
                <p>No Games</p>
            @endforelse


            <div class="mt-5 pb-5">
                @include('frontend.partials.pagination', ['totalQueryGame' => $totalQueryGame])
            </div>
        </div>
    </div>
</div>
