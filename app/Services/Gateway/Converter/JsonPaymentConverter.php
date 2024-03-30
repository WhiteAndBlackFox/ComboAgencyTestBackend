<?php

namespace App\Services\Gateway\Converter;

use App\Services\Gateway\Model\GatewayPaymentModel;
use App\Services\Gateway\Model\JsonGatewayPaymentModel;
use Illuminate\Http\Request;

class JsonPaymentConverter implements PaymentConverterInterface
{
    public const GATEWAY_TYPE = 'application/json';

    public function convert(Request $request): GatewayPaymentModel
    {
        $jsonPaymentModel = new JsonGatewayPaymentModel();
        $convertData = [
            'merchantId' => $request->post('merchant_id'),
            'paymentId' => $request->post('payment_id'),
            'status' => $request->post('status'),
            'amount' => $request->post('amount'),
            'amountPaid' => $request->post('amount_paid'),
            'timestamp' => $request->post('timestamp'),
            'sign' => $request->post('sign'),
        ];
        foreach ($convertData as $key => $value) {
            $jsonPaymentModel->{$key} = $value;
        }

        return $jsonPaymentModel;
    }
}
