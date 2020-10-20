<div>
    <select name="platforms" wire:click="$emitUp('changePlatform')">
        @foreach($platforms as $platform1)
            <option value="{{ $platform1['slug'] }}">{{ $platform1['name'] }}</option>
        @endforeach
    </select>
</div>
