<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TicketService;
use App\Services\NotificationService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TicketService::class, function ($app) {
            return new TicketService(
                new NotificationService()
            );
        });

        $this->app->singleton(NotificationService::class);
    }

    public function boot(): void
    {
        //
    }
}
