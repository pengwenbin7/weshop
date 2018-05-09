<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        "App\Events\Event" => [
            "App\Listeners\EventListener",
        ],
        "App\Events\OrderCreatedEvent" => [
            "App\Listeners\OrderCreatedListener",
        ],
        "App\Events\OrderPaidEvent" => [
            "App\Listeners\OrderPaidListener",
        ],
        "App\Events\ShipmentCreatedEvent" => [
            "App\Listeners\ShipmentCreatedListener",
        ],
        "App\Events\OrderShippedEvent" => [
            "App\Listeners\OrderShippedListener",
        ],
        "App\Events\ProductPriceChangedEvent" => [
            "App\Listeners\ProductPriceChangedListener",
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
