<?php

namespace Aliraqi\Artisan\Scaffolding\Providers;

use Aliraqi\Artisan\Scaffolding\View\Commands\MakeViewCommand;
use Aliraqi\Artisan\Scaffolding\View\Commands\ScrapViewCommand;
use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/artisan-scaffolding.php', 'artisan-scaffolding');

        if (!file_exists(config_path('artisan-scaffolding.php'))) {
            $this->publishes([
                __DIR__.'/../../config/artisan-scaffolding.php' => config_path('artisan-scaffolding.php'),
            ], 'config');
        }

        if (!is_dir(app_path('Console/stubs'))) {
            $this->publishes([
                __DIR__.'/../Console/stubs' => app_path('Console/stubs'),
            ], 'stubs');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            MakeViewCommand::class,
            ScrapViewCommand::class,
        ]);

        $this->app->register(ArtisanServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            MakeViewCommand::class,
            ScrapViewCommand::class,
        ];
    }
}
