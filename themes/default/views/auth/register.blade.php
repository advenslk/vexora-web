<section class="auth" data-mode="register">
    <div class="auth-media" aria-hidden="true"></div>

    <div class="auth-stage">
        <div class="auth-copy">
            <a class="auth-brand" href="{{ route('home') }}" wire:navigate aria-label="Vexora Cloud home">
                <img src="{{ asset('assets/vexora-logo-new.png') }}" alt="Vexora Cloud logo">
                <span>
                    Vexora Cloud
                    <small>Premium hosting panel</small>
                </span>
            </a>

            <p class="eyebrow">Create client account</p>
            <h1>Start hosting with Vexora Cloud.</h1>
            <p>Create your billing account to order Minecraft hosting, Discord bot hosting and manage support from one secure panel.</p>

            <dl>
                <div>
                    <dt>Setup</dt>
                    <dd>Instant</dd>
                </div>
                <div>
                    <dt>Storage</dt>
                    <dd>NVMe</dd>
                </div>
                <div>
                    <dt>Support</dt>
                    <dd>Tickets</dd>
                </div>
            </dl>
        </div>

        <div class="auth-form-panel">
            <form class="auth-form auth-card auth-form--wide" wire:submit.prevent="submit" id="register">
                <div class="mobile-logo">
                    <img src="{{ asset('assets/vexora-logo-new.png') }}" alt="Vexora Cloud logo">
                    <span>Vexora Cloud</span>
                </div>

                <p class="panel-kicker">Create account</p>
                <h1>{{ __('auth.sign_up_title') }}</h1>
                <p>Set up your Vexora Cloud billing profile and continue to checkout.</p>

                <div class="auth-grid">
                    <x-form.input name="first_name" type="text" :label="__('general.input.first_name')"
                        :placeholder="__('general.input.first_name_placeholder')" wire:model="first_name" required />
                    <x-form.input name="last_name" type="text" :label="__('general.input.last_name')"
                        :placeholder="__('general.input.last_name_placeholder')" wire:model="last_name" required />

                    <x-form.input name="email" type="email" :label="__('general.input.email')"
                        :placeholder="__('general.input.email_placeholder')" required wire:model="email" divClass="auth-span" />

                    <x-form.input name="password" type="password" :label="__('general.input.password')" :placeholder="__('general.input.password_placeholder')"
                        wire:model="password" required />
                    <x-form.input name="password_confirm" type="password" :label="__('general.input.password_confirmation')"
                        :placeholder="__('general.input.password_confirmation_placeholder')" wire:model="password_confirmation" required />

                    <x-form.properties :custom_properties="$custom_properties" :properties="$properties" />

                    @if(config('settings.tos'))
                    <div class="auth-span">
                        <x-form.checkbox wire:model="tos" name="tos" required>
                            {{ __('product.tos') }}
                            <a href="{{ config('settings.tos') }}" target="_blank">
                                {{ __('product.tos_link') }}
                            </a>
                        </x-form.checkbox>
                    </div>
                    @endif
                </div>

                <x-captcha :form="'register'" />

                <x-button.primary class="w-full mt-2">{{ __('auth.sign_up') }}</x-button.primary>

                <div class="switch">
                    {{ __('auth.already_have_account') }}
                    <a href="{{ route('login') }}" wire:navigate>{{ __('auth.sign_in') }}</a>
                </div>
            </form>
        </div>
    </div>
</section>
