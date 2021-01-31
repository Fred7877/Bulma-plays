<?php

namespace App\Console\Commands;

use App\Enums\SizeImage;
use App\Models\CustomGame;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;

class JWJsonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwjson';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the json jw';

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
        $client = new Client();
        $response = json_decode($client->get('https://jeuweb.org/our-games.json')->getBody()->getContents(), true);

        $path = 'imagePresentation/%s/%s/%s';

        collect($response['data'])->each(function($game) use($path){

            try {
                $filename = basename($game['image']);
                $extension = Str::of($filename)->after('.');
                $nameGame = $game['name'];
                foreach (SizeImage::getKeys() as $key) {
                    $values = SizeImage::getValue($key);

                    $image = Image::make($game['image'])->resize($values['w'], $values['h'])->encode($extension);
                    $pathS3 = sprintf($path, Str::slug($nameGame), $key, $filename);
                    Storage::disk('s3')->put($pathS3, (string)$image, 'public');
                }

                CustomGame::firstOrCreate(
                    [
                        'user_id' => 1,
                        'name' => $game['name'],
                    ],
                    [
                        'publish_date' => Carbon::now(),
                        'first_release_date' =>  null,
                        'image' => sprintf($path, Str::slug($nameGame), '_format_', $filename),
                        'summary' => $game['description']
                    ]
                );
            }catch(\Exception $e) {
                Log::error($e->getMessage());
            }
        });
    }
}
