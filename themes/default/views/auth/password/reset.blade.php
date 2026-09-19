<form class="vexora-card mx-auto mt-10 flex w-full max-w-lg flex-col gap-4 px-6 py-8 sm:px-10"
    wire:submit="submit" id="reset">
    <div class="flex flex-col items-center py-6 text-center">
        <x-logo class="h-10" />
        <span class="mt-5 vexora-kicker">Vexora Cloud</span>
        <h1 class="mt-3 text-3xl font-bold">{{ __('auth.reset_password') }}</h1>
    </div>
    <x-form.input name="email" type="text" :label="__('general.input.email')" :placeholder="__('general.input.email_placeholder')" wire:model="email" required disabled />

    <x-form.input name="password" type="password" :label="__('general.input.password')" :placeholder="__('general.input.password_placeholder')" wire:model="password" required />
    <x-form.input name="password_confirm" type="password" :label="__('general.input.password_confirmation')" :placeholder="__('general.input.password_confirmation_placeholder')"
        wire:model="password_confirmation" required />

    <x-captcha :form="'reset'" />

    <x-button.primary class="w-full" type="submit">{{ __('auth.reset_password') }}</x-button.primary>
</form>
