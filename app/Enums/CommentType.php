<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * Class CommentType
 * @package App\Enums
 */
final class CommentType extends Enum implements LocalizedEnum
{
    const Comments = 1;
    const Tips = 2;
}
