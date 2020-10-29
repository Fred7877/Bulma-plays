<?php

use App\Models\Translation;
use Illuminate\Support\Str;

function getTranslation($gameId, $field = 'summary', $lang = 'FR')
{
    $translation = Translation::where('game_id', $gameId)->where('field', $field)->first();

    return isset($translation->translations[Str::upper($lang)]) ? $translation->translations[Str::upper($lang)] : '';
}
