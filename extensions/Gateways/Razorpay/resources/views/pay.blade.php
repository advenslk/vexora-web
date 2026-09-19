<div class="razorpay-checkout">
    <div class="mb-4 rounded-md border border-neutral/70 bg-background-secondary p-4">
        <h3 class="text-lg font-semibold">Pay with Razorpay</h3>
        <p class="mt-1 text-sm text-base/60">Complete your Vexora Cloud invoice securely through Razorpay.</p>
    </div>

    <form method="POST" action="{{ $callbackUrl }}" id="razorpay-payment-form">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        <x-button.primary type="button" class="w-full" id="razorpay-pay-button">
            Pay {{ $invoice->currency_code }} {{ number_format($invoice->remaining, 2) }}
        </x-button.primary>
    </form>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        (() => {
            const button = document.getElementById('razorpay-pay-button');
            const form = document.getElementById('razorpay-payment-form');

            if (!button || !form || !window.Razorpay) return;

            const checkout = new Razorpay({
                key: @json($keyId),
                amount: @json($amount),
                currency: 'INR',
                name: @json($companyName),
                description: @json('Invoice #' . ($invoice->number ?? $invoice->id)),
                order_id: @json($order['id'] ?? null),
                prefill: {
                    name: @json($invoice->user?->name),
                    email: @json($invoice->user?->email),
                },
                theme: {
                    color: '#2563eb'
                },
                handler(response) {
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id || '';
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id || '';
                    document.getElementById('razorpay_signature').value = response.razorpay_signature || '';
                    form.submit();
                },
            });

            button.addEventListener('click', () => checkout.open());
            setTimeout(() => checkout.open(), 250);
        })();
    </script>
</div>
