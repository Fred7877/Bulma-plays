<?php

use App\Models\Translation;
use Illuminate\Support\Str;

function getTranslation($gameId, $field = 'summary', $lang = 'FR')
{
    $translation = Translation::where('game_id', $gameId)->where('field', $field)->first();

    return isset($translation->translations[Str::upper($lang)]) ? $translation->translations[Str::upper($lang)] : '';
}


function getFlag($lang = null, $size = '16x16')
{
    $html = '';
    if ($lang === null) {
        if (Str::lower(App::getLocale()) == 'fr') {
            $html = '<img class="image is-'.$size.'" src="' . asset('storage/assets/images/fr_flag.png') . '">';
        } else {
            $html = '<img class="image is-'.$size.'" src="' . asset('storage/assets/images/en_flag.png') . '">';
        }
    } else {
        if (Str::lower($lang) === 'fr') {
            $html = '<img class="image is-'.$size.'" src="' . asset('storage/assets/images/fr_flag.png') . '">';
        } else {
            $html = '<img class="image is-'.$size.'" src="' . asset('storage/assets/images/en_flag.png') . '">';
        }
    }

    return $html;
}
