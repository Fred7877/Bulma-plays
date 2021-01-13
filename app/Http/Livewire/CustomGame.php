<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CustomGame extends Component
{
    use WithFileUploads;

    const SUMMARY_MAX_LENGTH = 500;

    public $imagePresentation;
    public $published = false;

    public $customGame;

    public $platforms = null;
    public $genres = null;
    public $gameModes = null;
    public $themes = null;

    public $platformsSelected = [];
    public $genresSelected = [];
    public $gameModesSelected = [];
    public $themesSelected = [];

    public $dateRelease;
    public $multiplayer;

    public $name;
    public $summary;
    public $numCharSummary = 0;
    public $classNumCharSummary = 'has-text-grey';
    public $newLinkValues = [];
    public $newScreenshotValues = [];
    public $newProductorValues = [];
    public $newVideoValues = [];

    public $linkables = [];
    public $actionForm;
    public $actionMethod;
    public $screenshotValues = [];
    public $submitLoading = '';
    public $commentModeration;

    public $metas = [];

    public $screenshots = [];

    protected $rules = [
        'name' => 'required|min:2|unique:custom_games',
        'imagePresentation' => 'image',

    ];

    protected $messages = [
        'name.unique' => 'Ce titre existe déjà',
        'imagePresentation.image' => 'Doit-être une image',
        'newVideoValues.mimetypes' => 'Doit-être une vidéo',
    ];

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

    public function submit()
    {
        $this->submitLoading = 'is-loading';
    }

    public function updatedPublished($published)
    {
        if ($published) {
            $this->dispatchBrowserEvent('published');
        }
    }

    public function updated($propertyName, $value)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedSummary()
    {
        $summaryLength = strlen($this->summary);
        $this->numCharSummary = $summaryLength;

        if ($summaryLength >= self::SUMMARY_MAX_LENGTH) {
            $this->summary = substr($this->summary, 0, self::SUMMARY_MAX_LENGTH);
            $this->numCharSummary = self::SUMMARY_MAX_LENGTH;
        }

        if ($this->numCharSummary > 150 && $this->numCharSummary < 300) {
            $this->classNumCharSummary = 'has-text-success';
        } else if ($this->numCharSummary > 300 && $this->numCharSummary < 425) {
            $this->classNumCharSummary = 'has-text-warning';
        } else if ($this->numCharSummary > 425) {
            $this->classNumCharSummary = 'has-text-danger';
        } else {
            $this->classNumCharSummary = 'has-text-grey';
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
        $key = count($this->newProductorValues);
        $this->newProductorValues[$key]['value'] = '';
    }

    public function removeProductor($key)
    {
        unset($this->newProductorValues[$key]);

        // Keep the productors linkables
        $linkables = [];
        foreach ($this->newProductorValues as $k => $productor) {
            if (key_exists($k, $this->linkables)) {
                $linkables[$k] = $productor['value'];
            }
        }

        // Reindex the array newProductorValues and reset linkables
        $this->newProductorValues = array_values($this->newProductorValues);
        $this->linkables = [];

        // Restore the productors linkables
        foreach ($this->newProductorValues as $k => $productor) {
            if (in_array($productor['value'], $linkables)) {
                $this->linkables[$k] = true;
            }
        }
    }

    public function addLink()
    {
        $key = count($this->newLinkValues);
        $this->newLinkValues[$key]['value'] = '';
    }

    public function removeLink($key)
    {
        unset($this->newLinkValues[$key]);
        $this->newLinkValues = array_values($this->newLinkValues);
    }

    public function updatedNewScreenshotValues($propertyName, $i)
    {
        $this->validate([
            'newScreenshotValues.'.$i => 'image'
        ],
        ['newScreenshotValues.*.value.image' => 'Doit-être une image']);

        $this->dispatchBrowserEvent('updatedNewScreenshotValues',
            [
                'position' => count($this->newScreenshotValues),
                'temporaryUrl' => last($this->newScreenshotValues)['value']->temporaryUrl()
            ]
        );
    }

    public function addScreenshot()
    {
        $key = count($this->newScreenshotValues);
        $this->newScreenshotValues[$key]['value'] = '';
    }

    public function removeScreenshot($key)
    {
        unset($this->newScreenshotValues[$key]);
        unset($this->screenshotValues[$key]);
        $this->newScreenshotValues = array_values($this->newScreenshotValues);

        $this->dispatchBrowserEvent('removeScreenshot',
            [
                'position' => $key,
            ]
        );
    }

    public function updatedNewVideoValues($propertyName, $i)
    {
        $this->validate([
            'newVideoValues.'.$i => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4',
        ]);

        $this->dispatchBrowserEvent('updatedNewVideoValues',
            [
                'position' => count($this->newVideoValues),
                'temporaryUrl' => last($this->newVideoValues)['value']->temporaryUrl()
            ]
        );
    }

    public function addVideo()
    {
        $key = count($this->newVideoValues);
        $this->newVideoValues[$key]['value'] = '';
    }

    public function removeVideo($key)
    {
        unset($this->newVideoValues[$key]);
        unset($this->newVideoValues[$key]);
        $this->newVideoValues = array_values($this->newVideoValues);

        $this->dispatchBrowserEvent('removeVideo',
            [
                'position' => $key,
            ]
        );
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

    /**
     * Init.
     */
    public function mount()
    {
        $this->actionForm = route('custom-game.store');
        $this->actionMethod = 'post';

        if ($this->customGame) {
            $this->actionForm = route('custom-game.update', ['custom_game' => $this->customGame]);
            $this->actionMethod = 'put';

            $this->published = $this->customGame->publish_date !== null;

            $this->name = $this->customGame->name;
            $this->dateRelease = $this->customGame->first_release_date;
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
            });

            $this->customGame->productors->each(function ($item, $i) {
                $this->newProductorValues[$i]['value'] = $item->value;
                $this->linkables[$i] = (bool)$item->is_link;
            });

            if ($this->customGame->image) {
                $this->imagePresentation = Storage::disk('s3')->url($this->customGame->image);
            }

            $this->summary = $this->customGame->summary;

            $this->customGame->screenshots->each(function ($item, $i) {
                $path = Storage::disk('s3')->url(Str::of($item->path)->replace('_format_', 'LOGO_MED'));
                $this->newScreenshotValues[$i]['value'] = $path;
                $this->screenshotValues[$i]['value'] = $path;
            });

            $this->customGame->videos->each(function ($item, $i) {
                $path = Storage::disk('s3')->url($item->path);
                $this->newVideoValues[$i]['value'] = $path;
                $this->newVideoValues[$i]['value'] = $path;
            });

            $this->commentModeration = optional($this->customGame->moderations->last())->comment;
        }
    }

    public function render()
    {
        return view('livewire.custom-game');
    }
}
