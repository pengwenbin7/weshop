<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use App\Models\Cart;
use App\Observers\UserObserver;
use App\Observers\ProductObserver;
use App\Observers\CartObserver;

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
        
        User::observe(UserObserver::class);
        Product::observe(ProductObserver::class);
        Cart::observe(CartObserver::class);
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
