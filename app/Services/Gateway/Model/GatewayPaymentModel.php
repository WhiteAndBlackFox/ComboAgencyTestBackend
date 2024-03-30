<?php

namespace App\Services\Gateway\Model;

class GatewayPaymentModel implements PaymentModelInterface
{
    public string $status = '';

    protected array $castsStatus = [];

    protected int $timeout = 10_000;

    public function getStatus(): int
    {
        return data_get($this->castsStatus, strtolower($this->status), -1);
    }

    public function getMerchantId(): int
    {
        return -1;
    }

    public function getPaymentId(): int
    {
        return -1;
    }

    public function getAmount(): int
    {
        return -1;
    }

    public function getAmountPaid(): int
    {
        return -1;
    }

    public function getTimeoutPayment(): int
    {
        return $this->timeout;
    }
}
