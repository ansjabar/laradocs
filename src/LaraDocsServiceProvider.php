<?php

namespace AnsJabar\LaraDocs;

use Illuminate\Support\ServiceProvider;
use AnsJabar\LaraDocs\Commands\GenerateDocs;

class LaraDocsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laradocs.php', 'laradocs'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laradocs');
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('ansjabar/laradocs'),
            __DIR__.'/../config/laradocs.php' => config_path('laradocs.php'),
        ]);
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateDocs::class,
            ]);
        }
    }
}
