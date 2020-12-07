<?php

namespace App\Http\Controllers\backend;

use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Models\Moderation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ModerationController extends Controller
{
    public function moderation(Request $request)
    {

        Moderation::create([
            'comment_id' => $request->get('comment_id'),
            'status' => $request->get('status'),
        ]);

        foreach (Languages::getKeys() as $lang) {
            Cache::forget('game-' . $request->get('game_slug') . '-' . $lang);
        }

        return back();
    }
}