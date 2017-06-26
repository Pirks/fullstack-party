<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GithubServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Components\Github\GithubInterface::class, function ($app) {
            return new \App\Components\Github\Github(config('github.url'),
                    config('github.api_url'),
                    config('github.client_id'),
                    config('github.client_secret')
                );
        });
    }
}
