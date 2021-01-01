<div class="mb-2">

    <p>
        <b>Mode multijoueur :</b>
    <p>
    <div class="field">
        <label class="checkbox">
            Lan
            <input type="checkbox" name="multiplayer[lan]" @if(key_exists('lan', $metas)) checked="checked" @endif>
        </label>
    </div>

    <div class="field">
        <label class="checkbox">
            Coop offline
            <input type="checkbox" name="multiplayer[offline]"
                   @if(key_exists('offline', $metas)) checked="checked" @endif>
        </label>
    </div>
    <div class="field">
        <label class="checkbox">
            Coop online
            <input type="checkbox" name="multiplayer[online]" @if(key_exists('online', $metas)) checked="checked" @endif>
        </label>
    </div>
    <div class="field">
        <label class="checkbox">
            Max coop online
            <input type="checkbox" name="multiplayer[max_coop_online]" @if(key_exists('max_coop_online', $metas)) checked="checked" @endif>
        </label>
    </div>
</div>
