<?php

namespace App\Models;

use App\Models\RelationShips\CustomGameRelationShipsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CustomGame extends Model
{
    use HasFactory, HasSlug, CustomGameRelationShipsTrait;

    protected $guarded = [];

    protected $casts = ['links' => 'array'];

    protected $dates = ['date_release' => 'datetime:Y-m-d'];

    /**
     * Set the slug.
     *
     * @return void
     */
    public function setSlugAttribute()
    {
        $this->attributes['slug'] = Str::slug($this->attributes['name']);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
