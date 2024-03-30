<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeStatusPaymentRequest;
use App\Http\Requests\NewPaymentRequest;
use App\Models\Payment;
use App\Services\Gateway\Model\GatewayPaymentModel;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function new(NewPaymentRequest $request): JsonResponse
    {
        /** @var GatewayPaymentModel $gatewayPayment */
        $gatewayPayment = $request->attributes->get('gatewayPayment');

        $payment = new Payment();
        $payment->merchant_id = $gatewayPayment->getMerchantId();
        $payment->payment_id = $gatewayPayment->getPaymentId();
        $payment->status = $gatewayPayment->getStatus();
        $payment->amount = $gatewayPayment->getAmount();
        $payment->amount_paid = $gatewayPayment->getAmountPaid();
        $payment->save();

        return new JsonResponse('Payment is created.');
    }

    public function changeStatus(ChangeStatusPaymentRequest $request): JsonResponse
    {
        /** @var GatewayPaymentModel $gatewayPayment */
        $gatewayPayment = $request->attributes->get('gatewayPayment');

        $gatewayStatus = $gatewayPayment->getStatus();

        $payment = Payment::where('merchant_id', $gatewayPayment->getMerchantId())
            ->where('payment_id', $gatewayPayment->getPaymentId())
            ->whereNot('status', $gatewayStatus)
            ->firstOrFail()
        ;

        $payment->status = $gatewayStatus;
        $payment->save();

        return new JsonResponse('Payment status is changed.');
    }
}
