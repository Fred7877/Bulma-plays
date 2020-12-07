<?php


namespace App\Services;


use App\Models\Translation;
use GuzzleHttp\Client;

class AutoTranslation
{
    private $authKey;

    public function __construct()
    {
        $this->authKey = config('deepl.auth_key');
    }

    public function translate($text = '', $field = 'summary', $gameId = null, $targetLang = 'FR', $sourceLang = 'EN')
    {
        if (($text !== '' && $gameId !== null) && config('deepl.is_translate')) {

            // Is the md5 exist ?
            $md5 = md5($text);
            $translate = Translation::where('md5', $md5)->first();

            if ($translate === null) {
                $client = new Client();
                $translation = $client->get('https://api.deepl.com/v2/translate', [
                    'form_params' =>
                        [
                            'auth_key' => $this->authKey,
                            'text' => $text,
                            'source_lang' => $sourceLang,
                            'target_lang' => $targetLang
                        ]
                ])->getBody()->getContents();

                $translation = json_decode($translation, true);

                if (isset($translation['translations'][0]['text'])) {
                    Translation::firstOrCreate(
                        [
                            'md5' => md5($text)
                        ],
                        [
                            'game_id' => $gameId,
                            'field' => $field,
                            'translations' => [
                                $sourceLang => $text,
                                $targetLang => $translation['translations'][0]['text'],
                            ],
                        ]
                    );
                }
            }
        }

        return $text;
    }
}
