<?php

namespace App\Http\Middleware\Gateways;

use App\Models\Payment;
use App\Services\Gateway\Converter\JsonPaymentConverter;
use App\Services\Gateway\Converter\MultipartPaymentConverter;
use App\Services\Gateway\Model\GatewayPaymentModel;
use App\Services\Gateway\PaymentBlocker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Gateway
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response) $next
     *
     * @return RedirectResponse|Response
     */
    public function handle(Request $request, \Closure $next)
    {
        switch ($request->headers->get('Content-Type')) {
            case MultipartPaymentConverter::GATEWAY_TYPE:
                $classConverter = MultipartPaymentConverter::class;

                break;

            case JsonPaymentConverter::GATEWAY_TYPE:
                $classConverter = JsonPaymentConverter::class;

                break;

            default:
                $classConverter = null;
        }

        if (null === $classConverter) {
            return $next($request);
        }

        $converter = app($classConverter);

        /** @var GatewayPaymentModel $gatewayPayment */
        $gatewayPayment = $converter->convert($request);

        if (Payment::STATUS_NEW === $gatewayPayment->getStatus()) {
            PaymentBlocker::createPayment($gatewayPayment);
        } else {
            PaymentBlocker::updatePayment($gatewayPayment);
        }

        $request->attributes->set('gatewayPayment', $gatewayPayment);

        return $next($request);
    }
}
