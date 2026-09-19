<div
    class="vexora-card mx-auto mt-10 flex w-full max-w-2xl flex-col gap-2 px-6 py-8 sm:px-10">
    <span class="vexora-kicker">Vexora Cloud</span>
    <h1 class="mt-2 text-3xl font-bold">{{ __('auth.verification.notice') }}</h1>
    <p class="mt-2">{{ __('auth.verification.check_your_email') }}</p>

    <form class="flex flex-col gap-2 mt-4" wire:submit.prevent="submit" id="verify-email">
        <x-captcha :form="'verify-email'" />

        <p class="text-base">{{ __('auth.verification.not_received') }}</p>
        <x-button.primary class="w-full" type="submit">{{ __('auth.verification.request_another') }}</x-button.primary>
    </form>
</div>
