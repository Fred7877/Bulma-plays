<?php

namespace App\Http\Controllers;

use App\Enums\PopularPlatform;
use App\Models\CustomGame;
use App\Models\GameMode;
use App\Models\Genre;
use App\Models\Link;
use App\Models\Platform;
use App\Models\Productor;
use App\Models\Theme;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('frontend.createGame.index', [
            'platforms' => $this->getPopularPlatforms(),
            'genres' => Genre::all(),
            'gameModes' => GameMode::all(),
            'themes' => Theme::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $genres = isset($request->get('genres')[0]) && count($request->get('genres')) > 1 ?
            Genre::whereIn('id', $request->get('genres'))->pluck('id') : $request->get('genres');
        $platforms = isset($request->get('platforms')[0]) && count($request->get('platforms')) > 1 ?
            $this->getPopularPlatforms()->whereIn('id', $request->get('platforms'))->pluck('id') : $request->get('platforms');
        $themes = isset($request->get('themes')[0]) && count($request->get('themes')) > 1 ?
            Theme::whereIn('id', $request->get('themes'))->pluck('id') : $request->get('themes');
        $gameModes = isset($request->get('gameModes')[0]) && count($request->get('themes')) > 1 ?
            GameMode::whereIn('id', $request->get('gameModes'))->pluck('id') : $request->get('gameModes');

        $linksProductors = $request->get('productor_links');

        $customGame = CustomGame::firstOrCreate(
            [
                'user_id' => Auth::user()->id,
                'name' => $request->get('title'),
            ],
            [
                'publish_date' => $request->get('published') ? Carbon::now() : null,
                'date_release' => Carbon::createFromFormat('d/m/Y', $request->get('date_release'))
            ]
        );

        collect($request->get('links'))->map(function ($link) use ($customGame) {
            return Link::firstOrCreate([
                    'custom_game_id' => $customGame->id,
                    'url' => $link
                ]
            );
        });

        collect($request->get('productors'))->map(function ($productor, $index) use ($customGame, $linksProductors) {
            return Productor::firstOrCreate([
                    'custom_game_id' => $customGame->id,
                    'value' => $productor,
                    'is_link' => key_exists($index, $linksProductors ?? [])
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

        return redirect(route('custom-game.edit', [$customGame]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomGame  $customGame
     * @return \Illuminate\Http\Response
     */
    public function show(CustomGame $customGame)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomGame  $customGame
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(CustomGame $customGame)
    {
        return view('frontend.createGame.edit',
            [
                'customGame' =>
                    $customGame->load(['genres', 'platforms', 'themes', 'gameModes', 'customLinks', 'productors']),
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomGame  $customGame
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, CustomGame $customGame)
    {
        $genres = isset($request->get('genres')[0]) && count($request->get('genres')) > 1 ?
            Genre::whereIn('id', $request->get('genres'))->pluck('id') : $request->get('genres');
        $platforms = isset($request->get('platforms')[0]) && count($request->get('platforms')) > 1 ?
            $this->getPopularPlatforms()->whereIn('id', $request->get('platforms'))->pluck('id') : $request->get('platforms');
        $themes = isset($request->get('themes')[0]) && count($request->get('themes')) > 1 ?
            Theme::whereIn('id', $request->get('themes'))->pluck('id') : $request->get('themes');
        $gameModes = isset($request->get('gameModes')[0]) && count($request->get('themes')) > 1 ?
            GameMode::whereIn('id', $request->get('gameModes'))->pluck('id') : $request->get('gameModes');

        $linksProductors = $request->get('productor_links');

        $customGame->update(
            [
                'user_id' => Auth::user()->id,
                'name' => $request->get('title'),
            ],
            [
                'publish_date' => $request->get('published') ? Carbon::now() : null,
                'date_release' => Carbon::createFromFormat('d/m/Y', $request->get('date_release'))
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

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomGame  $customGame
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
