<div>
    <livewire:filter-games/>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3267490048749348"
            crossorigin="anonymous"></script>
    <!-- Bloc1 -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-3267490048749348"
         data-ad-slot="6345150642"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

    <div class="level-item has-text-centered">
        <div wire:loading>
            <div class="loader-wrapper is-active mt-5">
                <div class="loader is-loading"></div>
            </div>
        </div>
    </div>

    <div class="block mt-5"  wire:loading.remove wire:init="loadGames">
        <div>
            @forelse ($games as $game)
                @include('frontend.partials.card-game', ['game' => $game])
            @empty
                @if($totalQueryGame !== null && $totalQueryGame < 1)
                 <p class="is-size-3 has-text-white has-text-centered">{{ __('frontend.no_games') }} ¯-_(ツ)_-¯</p>
                @endif
            @endforelse

            @if ($totalQueryGame > 10)
                <div class="mt-5">
                    @include('frontend.partials.pagination', ['totalQueryGame' => $totalQueryGame])
                </div>
            @endif
        </div>
    </div>
</div>
