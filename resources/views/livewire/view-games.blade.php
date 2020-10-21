<div>
    <livewire:filter-games/>

    <div wire:loading>
        Processing search...
    </div>

    <div class="block mt-5">
        <div wire:loading.remove>
            @forelse ($games as $game)
                @include('frontend.partials.card-game', ['game' => $game])
            @empty
                <p>No Games</p>
            @endforelse
        </div>
    </div>
</div>
