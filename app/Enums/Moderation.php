<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class ModerationComment
 * @package App\Enums
 */
final class Moderation extends Enum
{
    const ModerationNOk = 0;
    const ModerationOk = 1;

    public static function getDescription($value): string
    {
        if ($value === self::ModerationNOk) {
            return 'NOK';
        }

        if ($value === self::ModerationOk) {
            return 'OK';
        }

        return parent::getDescription($value);
    }
}
