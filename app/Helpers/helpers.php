<?php

use App\Models\Translation;

function getTranslation($gameId, $field = 'summary', $lang = 'FR')
{
    $translation = Translation::where('game_id', $gameId)->where('field', $field)->first();

    return isset($translation->translations[$lang]) ? $translation->translations[$lang] : '';
}
