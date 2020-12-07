<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Platform;
use App\Models\ReleaseDate;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use MarcReichel\IGDBLaravel\Models\Game as GamesIGDB;
use MarcReichel\IGDBLaravel\Models\Platform as PlatformIGDB;
use MarcReichel\IGDBLaravel\Models\ReleaseDate as ReleaseDateIGDB;

class UpdateDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:db {--lastest : Get the last 500 games}';

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

        if ($this->option('lastest')) {
            GamesIGDB::take(500)->where('first_release_date', '<', Carbon::now())->orderBy('first_release_date', 'desc')->get()->each(function ($data) {

                $game = Game::firstOrCreate(
                    [
                        'slug' => $data->slug,
                        'game_id' => $data->id,
                        'platform' => implode(',', $data->platforms)
                    ],
                    [
                        'igdb' => $data->toArray(),
                    ],
                );

                if ($data->platforms) {
                    // $game->platforms()->attach(Platform::whereIn('data->id', $data->platforms)->get('id')->pluck('id'));
                }
            });
        } else {

            PlatformIGDB::all()->each(function ($data) {
                Platform::firstOrCreate(
                    [
                        'slug' => $data->slug,
                        'platform_id' => $data->id,
                    ],
                    ['data' => $data->toArray()]
                );
            });
            /*
                    ReleaseDateIGDB::all()->each(function($data){
                        ReleaseDate::firstOrCreate(
                            ['checksum' => $data->checksum],
                            ['data' => $data->toArray()]
                        );
                    });*/
            $countGames = GamesIGDB::count();
            $this->info($countGames);
            for ($i = 0; $i < $countGames; $i++) {
                $take = 500;
                $skip = $i * $take;
                GamesIGDB::skip($skip)->take($take)->where('first_release_date', '<', Carbon::now())->orderBy('first_release_date', 'desc')->get()->each(function ($data) {

                    $game = Game::firstOrCreate(
                        [
                            'slug' => $data->slug,
                            'game_id' => $data->id,
                            'platform' => implode(',', $data->platforms)
                        ],
                        [
                            'igdb' => $data->toArray(),
                        ],
                    );

                    if ($data->platforms) {
                        // $game->platforms()->attach(Platform::whereIn('data->id', $data->platforms)->get('id')->pluck('id'));
                    }
                });

                $this->info($skip);
            }
        }
        return 0;
    }
}
