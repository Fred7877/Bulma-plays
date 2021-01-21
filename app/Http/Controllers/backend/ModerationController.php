<?php

namespace App\Http\Controllers\backend;

use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Models\ModerationComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ModerationController extends Controller
{
    public function moderation(Request $request)
    {

        ModerationComment::create([
            'comment_id' => $request->get('comment_id'),
            'status' => $request->get('status'),
            'comment' => $request->get('comment_moderation'),
        ]);

        foreach (Languages::getKeys() as $lang) {
            Cache::forget('game-' . $request->get('game_slug') . '-' . $lang);
        }

        return back();
    }
}
