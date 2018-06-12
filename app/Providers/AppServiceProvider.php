<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Coupon;
use App\Models\AdminUser;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\Department;
use App\Models\AdminDepartment;
use App\Observers\AddressObserver;
use App\Observers\UserObserver;
use App\Observers\CouponObserver;
use App\Observers\AdminObserver;
use App\Observers\ProductObserver;
use App\Observers\ProductCategoryObserver;
use App\Observers\OrderObserver;
use App\Observers\PaymentObserver;
use App\Observers\ShipmentObserver;
use App\Observers\DepartmentObserver;
use App\Observers\AdminDepartmentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {        
        User::observe(UserObserver::class);
        Coupon::observe(CouponObserver::class);
        Address::observe(AddressObserver::class);
        AdminUser::observe(AdminObserver::class);
        Product::observe(ProductObserver::class);
        ProductCategory::observe(ProductCategoryObserver::class);
        Order::observe(OrderObserver::class);
        Payment::observe(PaymentObserver::class);
        Shipment::observe(ShipmentObserver::class);
        Department::observe(DepartmentObserver::class);
        AdminDepartment::observe(AdminDepartmentObserver::class);
        
        // adjust morphs too long for mariadb 10.1
        Schema::defaultStringLength(100);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("MPDF", function ($app) {
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
            $pdf = new \Mpdf\Mpdf([
                "fontDir" => array_merge($fontDirs, [
                    storage_path("fonts/")
                ]),
                "fontdata" => $fontData + [
                    "msyh" => [
                        "R" => "msyh.ttf",
                    ],
                    "msyhbd" => [
                        "B" => "msyhbd.ttf",
                    ],
                    "simsun" => [
                        "R" => "simsun.ttf",
                    ],
                ],
                "default_font" => "simsun",
            ]);
            $pdf->SetAuthor("马蜂科技（上海）有限公司");
            return $pdf;
        });
    }
}
