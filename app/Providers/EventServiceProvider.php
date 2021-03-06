<?php

namespace App\Providers;
use App\Listeners\RegisteredListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\OrderPaid;
use App\Listeners\UpdateProductSoldCount;
use App\Listeners\SendOrderPaidMail;
use App\Events\OrderReviewd;
use App\Listeners\UpdateProductRating;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        Registered::class => [
            RegisteredListener::class,
        ],
        OrderPaid::class => [
            UpdateProductSoldCount::class,
            SendOrderPaidMail::class,
        ],
        OrderReviewd::class=>[
            UpdateProductRating::class,
        ],
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
