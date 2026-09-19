<?php

namespace App\Services\Payment;

class PaymentAmountValidator
{
    public static function matches(
        string $invoiceCurrency,
        string $paymentCurrency,
        float|int|string $expectedAmount,
        float|int|string $paymentAmount
    ): bool {
        return strcasecmp($invoiceCurrency, $paymentCurrency) === 0
            && abs(round((float) $expectedAmount, 2) - round((float) $paymentAmount, 2)) < 0.005;
    }
}
