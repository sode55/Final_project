<?php

namespace App\Providers;

use App\Http\Controllers\PaymentProvider\ZarinpalController;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\PaymentInterface;
use App\Services\ZarinPalService;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(ZarinpalController::class)
            ->needs(PaymentInterface::class)
            ->give(zarinpalService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
