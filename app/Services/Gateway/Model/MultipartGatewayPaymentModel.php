<?php

namespace App\Services\Gateway\Model;

use App\Models\Payment;

class MultipartGatewayPaymentModel extends GatewayPaymentModel implements PaymentModelInterface
{
    public int $project;

    public int $invoice;

    public string $status;

    public int $amount;

    public int $amountPaid;

    public int $rand;

    protected int $timeout = 30_000;

    protected array $castsStatus = [
        'created' => Payment::STATUS_NEW,
        'inprogress' => Payment::STATUS_PENDING,
        'paid' => Payment::STATUS_COMPLETED,
        'expired' => Payment::STATUS_EXPIRED,
        'rejected' => Payment::STATUS_REJECTED,
    ];

    public function getMerchantId(): int
    {
        return $this->project;
    }

    public function getPaymentId(): int
    {
        return $this->invoice;
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
