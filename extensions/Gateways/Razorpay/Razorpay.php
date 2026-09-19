<?php

namespace Paymenter\Extensions\Gateways\Razorpay;

use App\Attributes\ExtensionMeta;
use App\Classes\Extension\Gateway;
use App\Helpers\ExtensionHelper;
use App\Models\Invoice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

#[ExtensionMeta(
    name: 'Razorpay',
    description: 'Accept payments via Razorpay.',
    version: '1.0.0',
    author: 'Vexora Cloud',
    url: 'https://razorpay.com/docs/payments/server-integration/php/',
)]
class Razorpay extends Gateway
{
    public function boot()
    {
        require __DIR__ . '/routes.php';
        View::addNamespace('gateways.razorpay', __DIR__ . '/resources/views');
    }

    public function getConfig($values = [])
    {
        return [
            [
                'name' => 'key_id',
                'label' => 'Razorpay Key ID',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'key_secret',
                'label' => 'Razorpay Key Secret',
                'type' => 'text',
                'encrypted' => true,
                'required' => true,
            ],
            [
                'name' => 'webhook_secret',
                'label' => 'Webhook Secret',
                'type' => 'text',
                'encrypted' => true,
                'required' => false,
            ],
        ];
    }

    public function pay(Invoice $invoice, $total)
    {
        if ($invoice->currency_code !== 'INR') {
            throw new Exception('Razorpay can only be used for INR invoices.');
        }

        $amount = (int) round($total * 100);
        $order = $this->request('post', '/orders', [
            'amount' => $amount,
            'currency' => 'INR',
            'receipt' => 'invoice_' . $invoice->id,
            'notes' => [
                'invoice_id' => (string) $invoice->id,
                'user_id' => (string) $invoice->user_id,
            ],
        ]);

        return view('gateways.razorpay::pay', [
            'invoice' => $invoice,
            'order' => $order,
            'keyId' => $this->config('key_id'),
            'amount' => $amount,
            'companyName' => config('settings.company_name', 'Vexora Cloud'),
            'callbackUrl' => route('extensions.gateways.razorpay.callback', $invoice),
        ]);
    }

    public function callback(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'razorpay_payment_id' => ['required', 'string', 'max:255'],
            'razorpay_order_id' => ['required', 'string', 'max:255'],
            'razorpay_signature' => ['required', 'string', 'max:255'],
        ]);

        $expected = hash_hmac(
            'sha256',
            $data['razorpay_order_id'] . '|' . $data['razorpay_payment_id'],
            $this->config('key_secret'),
        );

        if (!hash_equals($expected, $data['razorpay_signature'])) {
            abort(400, 'Invalid Razorpay signature.');
        }

        $payment = $this->request('get', '/payments/' . $data['razorpay_payment_id']);

        if (($payment['status'] ?? null) !== 'captured' && ($payment['status'] ?? null) !== 'authorized') {
            abort(400, 'Razorpay payment is not complete.');
        }

        $amount = ((int) ($payment['amount'] ?? 0)) / 100;
        $fee = isset($payment['fee']) ? ((int) $payment['fee']) / 100 : null;

        ExtensionHelper::addPayment($invoice, 'Razorpay', $amount, $fee, $data['razorpay_payment_id']);

        return redirect()->route('invoices.show', $invoice)->with('notification', [
            'type' => 'success',
            'message' => 'Payment received successfully.',
        ]);
    }

    public function webhook(Request $request)
    {
        $secret = $this->config('webhook_secret');

        if ($secret) {
            $expected = hash_hmac('sha256', $request->getContent(), $secret);
            if (!hash_equals($expected, (string) $request->header('X-Razorpay-Signature'))) {
                abort(400, 'Invalid Razorpay webhook signature.');
            }
        }

        $payload = $request->json()->all();
        $event = $payload['event'] ?? null;
        $payment = $payload['payload']['payment']['entity'] ?? null;

        if ($event !== 'payment.captured' || !$payment) {
            return response()->json(['status' => 'ignored']);
        }

        $invoiceId = $payment['notes']['invoice_id'] ?? null;
        if (!$invoiceId) {
            $order = isset($payment['order_id']) ? $this->request('get', '/orders/' . $payment['order_id']) : null;
            $receipt = $order['receipt'] ?? '';
            $invoiceId = str_starts_with($receipt, 'invoice_') ? substr($receipt, 8) : null;
        }

        if (!$invoiceId) {
            return response()->json(['status' => 'missing_invoice']);
        }

        $amount = ((int) ($payment['amount'] ?? 0)) / 100;
        $fee = isset($payment['fee']) ? ((int) $payment['fee']) / 100 : null;

        ExtensionHelper::addPayment((int) $invoiceId, 'Razorpay', $amount, $fee, $payment['id'] ?? null);

        return response()->json(['status' => 'success']);
    }

    private function request(string $method, string $path, array $data = []): array
    {
        $response = Http::withBasicAuth($this->config('key_id'), $this->config('key_secret'))
            ->acceptJson()
            ->asJson()
            ->$method('https://api.razorpay.com/v1' . $path, $data);

        if (!$response->successful()) {
            throw new Exception('Razorpay API error: ' . ($response->json('error.description') ?? $response->body()));
        }

        return $response->json() ?? [];
    }
}
