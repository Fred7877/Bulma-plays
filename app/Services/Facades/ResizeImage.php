<?php


namespace App\Services\Facades;

use App\Services\ImageResize;
use Illuminate\Support\Facades\Facade;

class ResizeImage extends Facade
{

    protected static function getFacadeAccessor()
    {
        return ImageResize::class;
    }
}
