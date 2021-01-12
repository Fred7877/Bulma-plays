<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * Class CommentType
 * @package App\Enums
 */
final class SizeImage extends Enum implements LocalizedEnum
{
    const COVER_SMALL = ['w' => 90, 'h' => 128];
    const SCREENSHOT_MED = ['w' => 569, 'h' => 320];
    const COVER_BIG = ['w' => 264, 'h' => 374];
    const LOGO_MED = ['w' => 284, 'h' => 160];
    const SCREENSHOT_BIG = ['w' => 889, 'h' => 500];
    const SCREENSHOT_HUGE = ['w' => 1280, 'h' => 720];
    const THUMB = ['w' => 90, 'h' => 90];
    const MICRO = ['w' => 35, 'h' => 35];
    const _720P = ['w' => 1280, 'h' => 720];
    const _1080PP = ['w' => 1920, 'h' => 1080];
}
