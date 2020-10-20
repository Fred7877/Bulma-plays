<div>
    <livewire:filter-games />

    <div wire:loading>
        Processing search...
    </div>

    <div class="block mt-5">
        <div wire:loading.remove>
            @foreach ($games as $game)
                @include('frontend.partials.card-game', ['game' => $game])
            @endforeach
        </div>
    </div>
</div>
