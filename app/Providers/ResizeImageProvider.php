<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ResizeImageProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('resizeimage',function(){
            return new ResizeImageProvider();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
