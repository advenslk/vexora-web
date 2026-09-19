<section class="auth" data-mode="login">
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

            <p class="eyebrow">Client billing access</p>
            <h1>Welcome back to Vexora Cloud.</h1>
            <p>Manage your Minecraft servers, Discord bot hosting, invoices and support tickets from one secure customer panel.</p>

            <dl>
                <div>
                    <dt>Storage</dt>
                    <dd>NVMe</dd>
                </div>
                <div>
                    <dt>Network</dt>
                    <dd>DDoS</dd>
                </div>
                <div>
                    <dt>Panel</dt>
                    <dd>Billing</dd>
                </div>
            </dl>
        </div>

        <div class="auth-form-panel">
            <form class="auth-form auth-card" wire:submit="submit" id="login">
                <div class="mobile-logo">
                    <img src="{{ asset('assets/vexora-logo-new.png') }}" alt="Vexora Cloud logo">
                    <span>Vexora Cloud</span>
                </div>

                <p class="panel-kicker">Sign in</p>
                <h1>{{ __('auth.sign_in_title') }}</h1>
                <p>Enter your account details to continue to the Vexora Cloud billing panel.</p>

                <x-form.input name="email" type="email" :label="__('general.input.email')"
                    :placeholder="__('general.input.email_placeholder')" wire:model="email" hideRequiredIndicator required autocomplete="email" />
                <x-form.input name="password" type="password" :label="__('general.input.password')"
                    :placeholder="__('general.input.password_placeholder')" required hideRequiredIndicator wire:model="password" autocomplete="current-password" />

                <div class="auth-row">
                    <x-form.checkbox name="remember" label="Remember me" wire:model="remember" />
                    <a href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
                </div>

                <x-captcha :form="'login'" />

                <x-button.primary class="w-full" type="submit">{{ __('auth.sign_in') }}</x-button.primary>

                {!! hook('auth.login') !!}

                @if (config('settings.oauth_github') || config('settings.oauth_google') || config('settings.oauth_discord'))
                <div class="auth-oauth">
                    <div class="auth-divider"><span>{{ __('auth.or_sign_in_with') }}</span></div>
                    <div class="auth-oauth-grid">
                        @foreach (['github', 'google', 'discord'] as $provider)
                        @if (config('settings.oauth_' . $provider))
                        <a href="{{ route('oauth.redirect', $provider) }}">
                            <img src="/assets/images/{{ $provider }}-dark.svg" alt="{{ $provider }}">
                            {{ __(ucfirst($provider)) }}
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!config('settings.registration_disabled', false))
                <div class="switch">
                    {{ __('auth.dont_have_account') }}
                    <a href="{{ route('register') }}" wire:navigate>{{ __('auth.sign_up') }}</a>
                </div>
                @endif
            </form>
        </div>
    </div>
</section>
