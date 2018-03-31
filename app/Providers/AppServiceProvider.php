<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ShopUser;
use App\Observers\ShopUserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ShopUser::observe(ShopUserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
