<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Game as GameService;

class Game extends Facade
{

    protected static function getFacadeAccessor()
    {
        return GameService::class;
    }
}
