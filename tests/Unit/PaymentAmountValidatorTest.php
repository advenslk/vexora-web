<?php

namespace Tests\Unit;

use App\Services\Payment\PaymentAmountValidator;
use PHPUnit\Framework\TestCase;

class PaymentAmountValidatorTest extends TestCase
{
    public function test_amount_and_currency_must_match(): void
    {
        $this->assertTrue(PaymentAmountValidator::matches('USD', 'USD', '10.00', 10));
        $this->assertFalse(PaymentAmountValidator::matches('USD', 'EUR', '10.00', 10));
        $this->assertFalse(PaymentAmountValidator::matches('USD', 'USD', '10.00', 9.99));
    }
}
