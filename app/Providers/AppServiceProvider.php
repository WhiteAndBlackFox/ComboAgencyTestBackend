<?php

namespace App\Providers;

use App\Services\Gateway\Converter\JsonPaymentConverter;
use App\Services\Gateway\Converter\MultipartPaymentConverter;
use App\Services\Gateway\Converter\PaymentConverterInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(PaymentConverterInterface::class, JsonPaymentConverter::class);
        app()->bind(PaymentConverterInterface::class, MultipartPaymentConverter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
