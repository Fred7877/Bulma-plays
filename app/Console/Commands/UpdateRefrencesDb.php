<?php

namespace App\Console\Commands;

use App\Models\GameMode;
use App\Models\Theme;
use App\Models\Platform;
use App\Models\Genre;
use Illuminate\Console\Command;
use MarcReichel\IGDBLaravel\Models\Genre as GenresIGDB;
use MarcReichel\IGDBLaravel\Models\Platform as PlatformIGDB;
use MarcReichel\IGDBLaravel\Models\GameMode as GameModeIGDB;
use MarcReichel\IGDBLaravel\Models\Theme as ThemeIGDB;

class UpdateRefrencesDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:refrences:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        GenresIGDB::get()->each(function ($genre) {
            Genre::firstOrCreate(
                [
                    'id_igdb' => $genre->id,
                    'name' => $genre->name,
                    'slug' => $genre->slug,
                ]
            );
        });

        PlatformIGDB::all()->each(function ($data) {
            Platform::firstOrCreate(
                [
                    'slug' => $data->slug,
                    'id_igdb' => $data->id,
                ],
                [
                    'name' => $data->name,
                    'platform_logo' => $data->platform_logo,
                    'alternative_name' => $data->alternative_name,
                    'data' => $data->toArray(),
                ]
            );
        });

        ThemeIGDB::all()->each(function ($data) {
            Theme::firstOrCreate(
                [
                    'slug' => $data->slug,
                    'id_igdb' => $data->id,
                ],
                [
                    'name' => $data->name,
                ]
            );
        });

        GameModeIGDB::all()->each(function ($data) {
            GameMode::firstOrCreate(
                [
                    'slug' => $data->slug,
                    'id_igdb' => $data->id,
                ],
                [
                    'name' => $data->name,
                ]
            );
        });

        return 0;
    }
}
