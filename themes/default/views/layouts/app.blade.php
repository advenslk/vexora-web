<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(in_array(app()->getLocale(), config('app.rtl_locales'))) dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php($documentTitle = request()->routeIs('home') ? 'Vexora Cloud - Minecraft Server Hosting India, Discord Bot Hosting & Cloud Billing' : trim(config('app.name', 'Vexora Cloud') . (isset($title) && $title ? ' - ' . $title : '')))
    <title>{{ $documentTitle }}</title>
    @livewireStyles
    @php($activeTheme = config('settings.theme') ?: 'default')
    @vite(['themes/' . $activeTheme . '/js/app.js', 'themes/' . $activeTheme . '/css/app.css'], $activeTheme)
    @include('layouts.colors')
    @php($isAuthRoute = request()->routeIs('login', 'register', 'password.*'))
    @php($usesWebsiteApp = request()->routeIs('home') || request()->is('game-servers', 'vps', 'vds', 'bot-hosting', 'free-hosting', 'support', 'contact', 'terms', 'refund-policy'))
    @php($usesExactTheme = request()->routeIs('category.*', 'products.*', 'product.*'))
    @if($usesWebsiteApp)
    <link rel="stylesheet" href="{{ asset('hide-scrollbars.css') }}?v=20260913-exact">
    <link rel="stylesheet" href="{{ asset('site-assets/index-BL5plpFo.css') }}?v=20260913-exact">
    @elseif($usesExactTheme)
    <link rel="stylesheet" href="{{ asset('vexora-exact.css') }}?v=20260913">
    @endif
    @unless($usesWebsiteApp)
    <link rel="stylesheet" href="{{ asset('vexora-paymenter-overrides.css') }}?v=20260913-static-auth">
    @endunless

    @if (config('settings.favicon'))
    <link rel="icon" href="{{ Storage::url(config('settings.favicon')) }}">
    @else
    <link rel="icon" type="image/png" href="{{ asset('favicon-vexora.png') }}?v=20260913">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=20260913">
    @endif
    @include('layouts.seo')

    <meta name="theme-color" content="{{ theme('primary') }}">

    {!! hook('head') !!}
</head>

<body class="w-full bg-background text-base min-h-screen flex flex-col antialiased"
    x-cloak
    x-data="{
        theme: $persist('dark').as('theme_mode'),
        systemDark: window.matchMedia('(prefers-color-scheme: dark)').matches,
        init() {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                this.systemDark = e.matches;
            });
        },
        get isDark() {
            return this.theme === 'dark' || (this.theme === 'system' && this.systemDark);
        }
    }"
    :class="{'dark': isDark}"
>
    {!! hook('body') !!}
    @unless($isAuthRoute || $usesWebsiteApp)
    <x-navigation />
    @endunless
    <div class="w-full flex flex-grow">
        @if (isset($sidebar) && $sidebar)
        <x-navigation.sidebar title="$title" />
        @endif
        <div class="{{ (isset($sidebar) && $sidebar) ? 'md:ml-64 rtl:ml-0 rtl:md:mr-64' : '' }} flex flex-col flex-grow overflow-auto">
            <main class="grow">
                {{ $slot }}
            </main>
            <x-notification />
            <x-confirmation />
            @unless($isAuthRoute || $usesWebsiteApp)
            <div class="flex">
                <x-navigation.footer />
            </div>
            @endunless
        </div>
        <x-impersonating />
    </div>
    @livewireScriptConfig
    {!! hook('footer') !!}
</body>

</html>
