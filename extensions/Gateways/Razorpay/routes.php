<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Paymenter\Extensions\Gateways\Razorpay\Razorpay;

Route::post('/extensions/gateways/razorpay/invoice/{invoice}/callback', [Razorpay::class, 'callback'])
    ->name('extensions.gateways.razorpay.callback');

Route::post('/extensions/gateways/razorpay/webhook', [Razorpay::class, 'webhook'])
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->name('extensions.gateways.razorpay.webhook');
