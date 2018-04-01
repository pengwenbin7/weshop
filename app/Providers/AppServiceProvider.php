<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
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
        Blade::directive("csrf", function () {
            $csrf = csrf_field();
            return "<?php echo '$csrf'; ?>";
        });

        Blade::directive("method", function ($method) {
            $str = "<input type=\"hidden\" name=\"_method\" value={$method}>";
            return "<?php echo '$str'; ?>";
        });

        Blade::directive("submit", function () {
            $str = "<input type=\"submit\" value=\"submit\">";
            return "<?php echo '$str'; ?>";
        });
        
        
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
