<?php

namespace App\Services\Gateway\Model;

use App\Models\Payment;

class JsonGatewayPaymentModel extends GatewayPaymentModel implements PaymentModelInterface
{
    public int $merchantId;

    public int $paymentId;

    public string $status;

    public int $amount;

    public int $amountPaid;

    public int $timestamp;

    public string $sign;

    protected int $timeout = 20_000;

    protected array $castsStatus = [
        'new' => Payment::STATUS_NEW,
        'pending' => Payment::STATUS_PENDING,
        'completed' => Payment::STATUS_COMPLETED,
        'expired ' => Payment::STATUS_EXPIRED,
        'rejected' => Payment::STATUS_REJECTED,
    ];

    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getAmountPaid(): int
    {
        return $this->amountPaid;
    }
}
