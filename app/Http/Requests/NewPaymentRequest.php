<?php

namespace App\Http\Requests;

use App\Models\Payment;
use App\Services\Gateway\Model\GatewayPaymentModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewPaymentRequest extends FormRequest
{
    public function rules(): array
    {
        /** @var GatewayPaymentModel $gatewayPayment */
        $gatewayPayment = $this->attributes->get('gatewayPayment');
        $merchantId = $gatewayPayment->getMerchantId();

        return [
            'payment_id' => [
                'nullable',
                !Rule::exists(Payment::class, 'payment_id')->whereMerchantId($merchantId),
            ],
        ];
    }
}
