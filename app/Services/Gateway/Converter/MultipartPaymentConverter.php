<?php

namespace App\Services\Gateway\Converter;

use App\Services\Gateway\Model\GatewayPaymentModel;
use App\Services\Gateway\Model\MultipartGatewayPaymentModel;
use Illuminate\Http\Request;

class MultipartPaymentConverter implements PaymentConverterInterface
{
    public const GATEWAY_TYPE = 'multipart/form-data';

    public function convert(Request $request): GatewayPaymentModel
    {
        $multipartPaymentModel = new MultipartGatewayPaymentModel();
        $convertData = [
            'project' => $request->post('project'),
            'invoice' => $request->post('invoice'),
            'status' => $request->post('status'),
            'amount' => $request->post('amount'),
            'amountPaid' => $request->post('amount_paid'),
            'rand' => $request->post('rand'),
        ];
        foreach ($convertData as $key => $value) {
            $multipartPaymentModel->{$key} = $value;
        }

        return $multipartPaymentModel;
    }
}
