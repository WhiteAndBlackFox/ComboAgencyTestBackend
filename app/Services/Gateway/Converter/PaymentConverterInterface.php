<?php

namespace App\Services\Gateway\Converter;

use App\Services\Gateway\Model\GatewayPaymentModel;
use Illuminate\Http\Request;

interface PaymentConverterInterface
{
    public function convert(Request $request): GatewayPaymentModel;
}
