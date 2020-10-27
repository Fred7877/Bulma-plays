<div>
    <livewire:filter-games/>

    <div wire:loading>
        Processing search...
    </div>

    <div class="block mt-5" id="infinite-list">
        <div wire:loading.remove >
            @forelse ($games as $game)
                @include('frontend.partials.card-game', ['game' => $game])
            @empty
                <p>No Games</p>
            @endforelse
        </div>

        @foreach($infiniteScroll as $game)
            @include('frontend.partials.card-game', ['game' => $game])
        @endforeach
    </div>
</div>

@push('js')
    <script>
        // Infinite scroll
        document.addEventListener("DOMContentLoaded", () => {
            var heightTotal = document.querySelectorAll('.card-game')[0].offsetHeight * document.querySelectorAll('.card-game').length;
            var height = document.querySelectorAll('.card-game')[0].offsetHeight * 4;
            var coeff = document.querySelectorAll('.card-game')[0].offsetHeight;
            var isAnimating = false;

            document.addEventListener('scroll', () => {
                if ((heightTotal - window.scrollY) <= (height + coeff)) {
                    if (isAnimating) {
                        return;
                    }
                    isAnimating = true;

                    Livewire.emit('loadMore');
                    heightTotal = document.querySelectorAll('.card-game')[0].offsetHeight * document.querySelectorAll('.card-game').length;

                    setTimeout(() => {
                        isAnimating = false;
                    }, 2000);
                }
            });
        });
    </script>
@endpush
