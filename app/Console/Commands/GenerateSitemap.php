<?php

namespace App\Console\Commands;

use App\Enums\Languages;
use App\Models\Game;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap';

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
        $sitemap = Sitemap::create();
        Game::all()->each(function ($game) use ($sitemap) {
            foreach (Languages::getValues() as $lang) {
                $sitemap->add(Url::create($lang . '/games/' . $game->slug)->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
            }
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        return 0;
    }
}
