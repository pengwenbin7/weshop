<?php

namespace Mfkj\ChianRegion;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class ChianRegionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('chianRegion', \Mfkj\ChianRegion\Middleware\ChianRegionMiddleware::class);

        $this->publishes([
            __DIR__.'/Config/chianRegion.php' => config_path('chianRegion.php'),
        ], 'chianRegion_config');

        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/Translations', 'chianRegion');

        $this->publishes([
            __DIR__ . '/Translations' => resource_path('lang/vendor/chianRegion'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/Views', 'chianRegion');

        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/chianRegion'),
        ]);

        $this->publishes([
            __DIR__ . '/Assets' => public_path('vendor/chianRegion'),
        ], 'chianRegion_assets');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Mfkj\ChianRegion\Commands\ChianRegionCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/chianRegion.php', 'chianRegion'
        );
    }
}
