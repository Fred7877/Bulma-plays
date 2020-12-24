<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use MarcReichel\IGDBLaravel\Models\Game as GamesIGDB;
use MarcReichel\IGDBLaravel\Models\Platform as PlatformIGDB;

class UpdateDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:db { --lastest : Get the last 500 games}';

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
            GamesIGDB::take(20)->where('first_release_date', '<', Carbon::now())->orderBy('first_release_date', 'desc')->get()->each(function ($data) {

                Game::firstOrCreate(
                    [
                        'slug' => $data->slug,
                        'game_id' => $data->id,
                        'platform' => implode(',', $data->platforms)
                    ],
                    [
                        'igdb' => $data->toArray(),
                    ],
                );
            });
        } else {

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

            $countGames = GamesIGDB::count();
            $this->info($countGames);
            for ($i = 0; $i < $countGames; $i++) {
                $take = 500;
                $skip = $i * $take;
                GamesIGDB::skip($skip)->take($take)->where('first_release_date', '<', Carbon::now())->orderBy('first_release_date', 'desc')->get()->each(function ($data) {

                    Game::firstOrCreate(
                        [
                            'slug' => $data->slug,
                            'game_id' => $data->id,
                            'platform' => implode(',', $data->platforms)
                        ],
                        [
                            'igdb' => $data->toArray(),
                        ],
                    );
                });

                $this->info($skip);
            }
        }

        return 0;
    }
}
