<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class CustomGame extends Component
{
    use WithFileUploads;

    const SYNOPSIS_MAX_LENGTH = 500;

    public $imagePresentation;

    public $customGame;

    public $platforms;
    public $genres;
    public $gameModes;
    public $themes;

    public $platformsSelected = [];
    public $genresSelected = [];
    public $gameModesSelected = [];
    public $themesSelected = [];

    public $dateRelease;
    public $multiplayer;

    public $title;
    public $synopsis;
    public $numCharSynopsis = 0;
    public $classNumCharSynopsis = 'has-text-grey';
    public $newLinks = [];
    public $newLinkValues = [];
    public $newScreenshotValues = [];
    public $newScreenshots = [];

    public $newProductors = [];
    public $newProductorValues = [];

    public $linkables = [];
    public $actionForm;
    public $actionMethod;

    public $metas = [];

    public $screenshots = [];

    protected $listeners = [
        'selectedDateRelease',
        'selectedPlatform',
        'unSelectedPlatform',
        'selectedGenre',
        'unSelectedGenre',
        'selectedGameMode',
        'unSelectedGameMode',
        'addLink',
        'removeLink',
        'unSelectedTheme',
        'selectedTheme',
        'linkable',
    ];

    public function updatedSynopsis()
    {
        $synopsisLength = strlen($this->synopsis);
        $this->numCharSynopsis = $synopsisLength;

        if ($synopsisLength >= self::SYNOPSIS_MAX_LENGTH) {
            $this->synopsis = substr($this->synopsis, 0, self::SYNOPSIS_MAX_LENGTH);
            $this->numCharSynopsis = self::SYNOPSIS_MAX_LENGTH;
        }

        if ($this->numCharSynopsis > 150 && $this->numCharSynopsis < 300) {
            $this->classNumCharSynopsis = 'has-text-success';
        } else if ($this->numCharSynopsis > 300 && $this->numCharSynopsis < 425) {
            $this->classNumCharSynopsis = 'has-text-warning';
        } else if ($this->numCharSynopsis > 425) {
            $this->classNumCharSynopsis = 'has-text-danger';
        } else {
            $this->classNumCharSynopsis = 'has-text-grey';
        }
    }

    public function linkable($key)
    {
        if (isset($this->linkables[$key])) {
            unset($this->linkables[$key]);
        } else {
            $this->linkables[$key] = true;
        }
    }

    public function addProductor()
    {
        $key = array_key_last($this->newProductors) + 1;
        $this->newProductors[$key] = $key;
        if (isset($this->newProductorValues[$key])) {
            $this->newProductorValues[$key - 1];
        }
    }

    public function addScreenshot()
    {
        $key = array_key_last($this->newScreenshots) + 1;
        $this->newScreenshots[$key] = $key;
        if (isset($this->newScreenshotValues[$key])) {
            $this->newScreenshotValues[$key - 1];
        }

    }

    public function removeProductor($key)
    {
        unset($this->newProductors[$key]);
        unset($this->newProductorValues[$key]);
    }

    public function addLink()
    {
        $key = array_key_last($this->newLinks) + 1;
        $this->newLinks[$key] = $key;
        if (isset($this->newLinkValues[$key])) {
            $this->newLinkValues[$key - 1];
        }
    }

    public function removeLink($key)
    {
        unset($this->newLinks[$key]);
        unset($this->newLinkValues[$key]);
    }

    public function removeScreenshot($key)
    {
        unset($this->newScreenshots[$key]);
        unset($this->newScreenshotValues[$key]);
    }

    /**
     * @param $platform
     */
    public function unSelectedPlatform($platform)
    {
        unset($this->platformsSelected[$platform]);
    }

    /**
     * @param $platform
     */
    public function selectedPlatform($platform)
    {
        $this->platformsSelected[$platform] = $this->platforms->where('id', $platform)->pluck('name')->first();
    }

    /**
     * @param $theme
     */
    public function selectedTheme($theme)
    {
        $this->themesSelected[$theme] = $this->themes->where('id', $theme)->pluck('name')->first();
    }

    /**
     * @param $platform
     */
    public function unSelectedTheme($theme)
    {
        unset($this->themesSelected[$theme]);
    }

    /**
     * @param $genre
     */
    public function selectedGenre($genre)
    {
        $this->genresSelected[$genre] = $this->genres->where('id', $genre)->pluck('name')->first();
    }

    /**
     * @param $genre
     */
    public function unSelectedGenre($genre)
    {
        unset($this->genresSelected[$genre]);
    }

    /**
     * @param $gameMode
     */
    public function selectedGameMode($gameMode)
    {
        $this->gameModesSelected[$gameMode] = $this->gameModes->where('id', $gameMode)->pluck('name')->first();
        if ($gameMode === '2') {
            $this->multiplayer = view('frontend.CustomGame.multiplayer-form', ['metas' => []])->toHtml();
        }
    }

    /**
     * @param $gameMode
     */
    public function unSelectedGameMode($gameMode)
    {
        unset($this->gameModesSelected[$gameMode]);
        if ($gameMode === '2') {
            $this->multiplayer = '';
        }
    }

    /**
     * @param $dateRelease
     */
    public function selectedDateRelease($dateRelease)
    {
        $this->dateRelease = $dateRelease;
    }

    public function mount()
    {
        $this->actionForm = route('custom-game.store');
        $this->actionMethod = 'post';

        if ($this->customGame) {
            $this->actionForm = route('custom-game.update', ['custom_game' => $this->customGame]);
            $this->actionMethod = 'put';

            $this->title = $this->customGame->name;
            $this->dateRelease = $this->customGame->date_release;
            $this->customGame->genres->each(function ($item) {
                $this->genresSelected[$item->id] = $item->name;
            });

            $this->customGame->platforms->each(function ($item) {
                $this->platformsSelected[$item->id] = $item->name;
            });

            $this->customGame->themes->each(function ($item) {
                $this->themesSelected[$item->id] = $item->name;
            });

            $this->customGame->gameModes->each(function ($item) {
                $this->gameModesSelected[$item->game_mode_id]['name'] = $item->name;

                if ($item->game_mode_id === 2) {
                    $this->multiplayer = view('frontend.CustomGame.multiplayer-form', ['metas' => $item->metas ?? []])->toHtml();
                }
            });

            $this->customGame->customLinks->each(function ($item, $i) {
                $this->newLinkValues[$i]['value'] = $item->url;
                if ($i > 0) {
                    $this->newLinks[$i]['value'] = $item->url;
                }
            });

            $this->customGame->productors->each(function ($item, $i) {
                $this->newProductorValues[$i]['value'] = $item->value;
                if ($i > 0) {
                    $this->newProductors[$i]['value'] = $item->url;
                }
                $this->linkables[$i] = (bool)$item->is_link;
            });

            $this->imagePresentation = $this->customGame->image;
        }
    }

    public function render()
    {
        return view('livewire.custom-game');
    }
}
