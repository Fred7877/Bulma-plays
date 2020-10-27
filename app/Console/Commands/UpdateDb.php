<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Platform;
use App\Models\ReleaseDate;
use Illuminate\Console\Command;
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
    protected $signature = 'update:db';

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
        PlatformIGDB::all()->each(function($data){
            Platform::firstOrCreate(
                ['slug' => $data->slug],
                ['data' => $data->toArray()]
            );
        });

        ReleaseDateIGDB::all()->each(function($data){
            ReleaseDate::firstOrCreate(
                ['checksum' => $data->checksum],
                ['data' => $data->toArray()]
            );
        });

        GamesIGDB::all()->each(function($data){
            $game = Game::firstOrCreate(
                ['slug' => $data->slug],
                ['data' => $data->toArray()],
            );

            if ($data->platforms) {
                $game->platforms()->attach(Platform::whereIn('data->id', $data->platforms)->get('id')->pluck('id'));
            }
        });

        return 0;
    }
}
