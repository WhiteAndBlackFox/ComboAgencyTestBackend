<?php

namespace App\Services\Gateway;

use App\Models\Payment;
use App\Services\Gateway\Model\GatewayPaymentModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class PaymentBlocker
{
    public static function createPayment(GatewayPaymentModel $gatewayPayment): void
    {
        Cache::put(self::getKey($gatewayPayment), time(), $gatewayPayment->getTimeoutPayment());
    }

    public static function updatePayment(GatewayPaymentModel $gatewayPayment): void
    {
        if (Payment::STATUS_COMPLETED === $gatewayPayment->status) {
            return;
        }

        if (self::isPaymentExpired($gatewayPayment)) {
            self::blockPayment($gatewayPayment);
        }
    }

    private static function isPaymentExpired(GatewayPaymentModel $gatewayPayment): bool
    {
        return Carbon::now()->diffInSeconds(
            Cache::get(self::getKey($gatewayPayment))
        ) > $gatewayPayment->getTimeoutPayment();
    }

    private static function blockPayment(GatewayPaymentModel $gatewayPayment): void
    {
        Cache::put(self::getKey($gatewayPayment), time(), $gatewayPayment->getTimeoutPayment() + 86_400);
        abort(403, 'Payment is blocked.');
    }

    private static function getKey(GatewayPaymentModel $gatewayPayment): string
    {
        return "{$gatewayPayment->getMerchantId()}:{$gatewayPayment->getPaymentId()}";
    }
}
