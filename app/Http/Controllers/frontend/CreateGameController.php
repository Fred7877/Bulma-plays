<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class CreateGameController extends Controller
{
    const PLATFORM_SLUG_WINDOWS = 'win';
    const PLATFORM_SLUG_LINUX = 'linux';
    const PLATFORM_SLUG_MAC = 'mac';
    const PLATFORM_BROWER = 'browser';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $platforms = Platform::get()->filter(function ($item) {

            if (isset($item['slug'])) {
                return (
                    $item['slug'] === self:: PLATFORM_SLUG_WINDOWS ||
                    $item['slug'] === self:: PLATFORM_SLUG_LINUX ||
                    $item['slug'] === self:: PLATFORM_SLUG_MAC ||
                    $item['slug'] === self:: PLATFORM_BROWER
                );
            }

            return false;
        });

        return view('frontend.createGame.index', ['platforms' => $platforms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
