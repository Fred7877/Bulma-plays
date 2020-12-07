<?php

use App\Models\Translation;
use Illuminate\Support\Str;

function getTranslation($gameId, $field = 'summary', $lang = 'FR')
{
    $translation = Translation::where('game_id', $gameId)->where('field', $field)->first();

    return isset($translation->translations[Str::upper($lang)]) ? $translation->translations[Str::upper($lang)] : '';
}


function getFlag($lang = null, $size = '16x16', $boostrap = false, $sizeImageBoostrap = '16')
{
    $language = ($lang === null) ? Str::lower(App::getLocale()) : Str::lower($lang);

    if ($boostrap) {
        $html = '<img width="'. $sizeImageBoostrap . 'px" src="' . asset('storage/assets/images/' . $language . '_flag.png') . '">';
    } else {
        $html = '<img class="image is-' . $size . '" src="' . asset('storage/assets/images/' . $language . '_flag.png') . '">';
    }

    return $html;
}
