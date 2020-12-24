<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PopularPlatform extends Enum
{
    const PLATFORM_SLUG_WINDOWS = 'win';
    const PLATFORM_SLUG_LINUX = 'linux';
    const PLATFORM_SLUG_MAC = 'mac';
    const PLATFORM_BROWER = 'browser';
}
