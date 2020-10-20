<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlatformGame extends Pivot
{
    use HasFactory;

    protected $table = 'platform_games';
}
