<?php

namespace App\Services\Gateway\Model;

interface PaymentModelInterface
{
    public function getStatus(): int;

    public function getMerchantId(): int;

    public function getPaymentId(): int;

    public function getAmount(): int;

    public function getAmountPaid(): int;

    public function getTimeoutPayment(): int;
}
