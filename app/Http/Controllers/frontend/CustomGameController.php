<?php

namespace App\Http\Controllers\frontend;

use App\Enums\PopularPlatform;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomGameRequest;
use App\Models\CustomGame;
use App\Models\CustomGameScreenshot;
use App\Models\CustomGameVideo;
use App\Models\GameMode;
use App\Models\Genre;
use App\Models\Link;
use App\Models\Platform;
use App\Models\Productor;
use App\Models\Theme;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomGameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.CustomGame.index', [
            'platforms' => $this->getPopularPlatforms(),
            'genres' => Genre::all(),
            'gameModes' => GameMode::all(),
            'themes' => Theme::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(CustomGameRequest $request)
    {
        $genres = isset($request->get('genres')[0]) && count($request->get('genres')) > 1 ?
            Genre::whereIn('id', $request->get('genres'))->pluck('id') : $request->get('genres');
        $platforms = isset($request->get('platforms')[0]) && count($request->get('platforms')) > 1 ?
            $this->getPopularPlatforms()->whereIn('id', $request->get('platforms'))->pluck('id') : $request->get('platforms');
        $themes = isset($request->get('themes')[0]) && count($request->get('themes')) > 1 ?
            Theme::whereIn('id', $request->get('themes'))->pluck('id') : $request->get('themes');
        $gameModes = isset($request->get('gameModes')[0]) && count($request->get('themes')) > 1 ?
            GameMode::whereIn('id', $request->get('gameModes'))->pluck('id') : $request->get('gameModes');
        $title = $request->get('title');

        $linksProductors = $request->get('productor_links');

        if ($request->hasFile('imagePresentation')) {
            $pathImage = $request->imagePresentation->storeAs('custom_game_images/' . Str::slug($title), $request->file('imagePresentation')->getClientOriginalName(), 's3');
        }

        $customGame = CustomGame::firstOrCreate(
            [
                'user_id' => Auth::user()->id,
                'name' => $title,
            ],
            [
                'publish_date' => $request->get('published') ? Carbon::now() : null,
                'date_release' => $request->get('date_release') ? Carbon::createFromFormat('d/m/Y', $request->get('date_release')) : null,
                'image' => $pathImage ?? null,
                'synopsis' => $request->get('synopsis'),
            ]
        );

        collect($request->get('links'))->each(function ($link) use ($customGame) {
            if ($link) {
                Link::firstOrCreate([
                        'custom_game_id' => $customGame->id,
                        'url' => $link
                    ]
                );
            }
        });

        collect($request->get('productors'))->each(function ($productor, $index) use ($customGame, $linksProductors) {
            if ($productor) {
                Productor::firstOrCreate([
                        'custom_game_id' => $customGame->id,
                        'value' => $productor,
                        'is_link' => key_exists($index, $linksProductors ?? [])
                    ]
                );
            }
        });

        collect($request->file('screenshots'))->each(function ($screenshot) use ($customGame, $title) {
            $pathScreenshot = $screenshot->storeAs('custom_game_screenshot/' . Str::slug($title), $screenshot->getClientOriginalName(), 's3');
            CustomGameScreenshot::firstOrCreate([
                    'custom_game_id' => $customGame->id,
                    'path' => $pathScreenshot,
                ]
            );
        });

        collect($request->file('videos'))->each(function ($video) use ($customGame, $title) {
            $pathVideo = $video->storeAs('custom_game_videos/' . Str::slug($title), $video->getClientOriginalName(), 's3');
            CustomGameVideo::firstOrCreate([
                    'custom_game_id' => $customGame->id,
                    'path' => $pathVideo,
                ]
            );
        });

        if ($request->has('multiplayer')) {
            $id = $gameModes[0];
            $gameModes = [];
            $gameModes[$id] = [
                'metas' => json_encode($request->get('multiplayer'))
            ];
        }

        $customGame->genres()->sync($genres);
        $customGame->platforms()->sync($platforms);
        $customGame->themes()->sync($themes);
        $customGame->gameModes()->sync($gameModes);

        Session::flash('message', 'Travail sauvegardé !');

        return redirect(route('custom-game.edit', [$customGame]));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CustomGame $customGame
     * @return \Illuminate\Http\Response
     */
    public function show(CustomGame $customGame)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\CustomGame $customGame
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(CustomGame $customGame)
    {

        return view('frontend.CustomGame.edit',
            [
                'customGame' =>
                    $customGame->load(['genres', 'platforms', 'themes', 'gameModes', 'customLinks', 'productors', 'screenshots']),
                'platforms' => $this->getPopularPlatforms(),
                'genres' => Genre::all(),
                'gameModes' => GameMode::all(),
                'themes' => Theme::all()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CustomGame $customGame
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CustomGameRequest $request, CustomGame $customGame)
    {

        $genres = isset($request->get('genres')[0]) && count($request->get('genres')) > 1 ?
            Genre::whereIn('id', $request->get('genres'))->pluck('id') : $request->get('genres');
        $platforms = isset($request->get('platforms')[0]) && count($request->get('platforms')) > 1 ?
            $this->getPopularPlatforms()->whereIn('id', $request->get('platforms'))->pluck('id') : $request->get('platforms');
        $themes = isset($request->get('themes')[0]) && count($request->get('themes')) > 1 ?
            Theme::whereIn('id', $request->get('themes'))->pluck('id') : $request->get('themes');
        $gameModes = isset($request->get('gameModes')[0]) && count($request->get('themes')) > 1 ?
            GameMode::whereIn('id', $request->get('gameModes'))->pluck('id') : $request->get('gameModes');
        $title = $request->get('title');
        $linksProductors = $request->get('productor_links');

        if ($request->imagePresentation !== null) {
            File::delete(public_path($customGame->image));
            $pathImage = $request->imagePresentation->storeAs('custom_game_images/' . Str::slug($title), $request->file('imagePresentation')->getClientOriginalName(), 's3');
            $customGame->update(['image' => $pathImage]);
        }

        $customGame->update(
            [
                'user_id' => Auth::user()->id,
                'name' => $request->get('title'),
                'publish_date' => $request->get('published') ? Carbon::now() : null,
                'date_release' => Carbon::createFromFormat('d/m/Y', $request->get('date_release')),
                'synopsis' => $request->get('synopsis'),
            ]
        );

        Link::where('custom_game_id', $customGame->id)->delete();
        collect($request->get('links'))->each(function ($link, $i) use ($customGame) {
            Link::firstOrCreate([
                    'custom_game_id' => $customGame->id,
                    'url' => $link
                ]
            );
        });

        Productor::where('custom_game_id', $customGame->id)->delete();
        collect($request->get('productors'))->map(function ($productor, $index) use ($customGame, $linksProductors) {
            return Productor::firstOrCreate([
                    'custom_game_id' => $customGame->id,
                    'value' => $productor,
                    'is_link' => key_exists($index, $linksProductors ?? [])
                ]
            );
        });


        $screenshotsCustoGame = CustomGameScreenshot::where('custom_game_id', $customGame->id)->get();
        $screenshotsCustoGame->each(function ($screenshotCustoGame) use ($request) {
            if (!in_array(Str::of($screenshotCustoGame->path)->basename(), collect($request->get('screenshotsHidden'))->map(function($item){
                return Str::of($item)->basename();
            })->toArray())) {
                Storage::disk('s3')->delete($screenshotCustoGame->path);
                $screenshotCustoGame->delete();
            }
        });

        collect($request->file('screenshots'))->each(function ($screenshot) use ($request, $title, $customGame) {
            $pathScreenshot = $screenshot->storeAs('custom_game_screenshot/' . Str::slug($title), $screenshot->getClientOriginalName(), 's3');
            CustomGameScreenshot::firstOrCreate([
                    'custom_game_id' => $customGame->id,
                    'path' => $pathScreenshot,
                ]
            );
        });

        $videosCustoGame = CustomGameVideo::where('custom_game_id', $customGame->id)->get();
        $videosCustoGame->each(function ($videoCustoGame) use ($request) {
            if (!in_array(Str::of($videoCustoGame->path)->basename(), collect($request->get('videosHidden'))->map(function($item){
                return Str::of($item)->basename();
            })->toArray())) {
                Storage::disk('s3')->delete($videoCustoGame->path);
                $videoCustoGame->delete();
            }
        });

        collect($request->file('videos'))->each(function ($video) use ($request, $title, $customGame) {
            $pathVideo = $video->storeAs('custom_game_video/' . Str::slug($title), $video->getClientOriginalName(), 's3');
            CustomGameVideo::firstOrCreate([
                    'custom_game_id' => $customGame->id,
                    'path' => $pathVideo,
                ]
            );
        });

        if ($request->has('multiplayer')) {
            $id = $gameModes[0];
            $gameModes = [];
            $gameModes[$id] = [
                'metas' => json_encode($request->get('multiplayer'))
            ];
        }

        $customGame->genres()->sync($genres);
        $customGame->platforms()->sync($platforms);
        $customGame->themes()->sync($themes);
        $customGame->gameModes()->sync($gameModes);

        Session::flash('message', 'Travail sauvegardé !');

        return redirect(route('custom-game.edit', ['custom_game' => $customGame]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CustomGame $customGame
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomGame $customGame)
    {
        //
    }

    private function getPopularPlatforms()
    {
        return Platform::get()->filter(function ($item) {

            if (isset($item['slug'])) {
                return (
                    $item['slug'] === PopularPlatform::PLATFORM_SLUG_WINDOWS ||
                    $item['slug'] === PopularPlatform:: PLATFORM_SLUG_LINUX ||
                    $item['slug'] === PopularPlatform:: PLATFORM_SLUG_MAC ||
                    $item['slug'] === PopularPlatform:: PLATFORM_BROWER
                );
            }

            return false;
        });
    }
}