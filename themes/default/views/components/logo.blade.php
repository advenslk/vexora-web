@php
$lightLogo = config('settings.logo');
$darkLogo = config('settings.logo_dark');
@endphp

@if ($lightLogo && $darkLogo)
<img src="{{ Storage::url($lightLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto inline-block dark:hidden']) }}>
<img src="{{ Storage::url($darkLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto hidden dark:inline-block']) }}>
@elseif ($lightLogo)
<img src="{{ Storage::url($lightLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto inline-block']) }}>
@elseif ($darkLogo)
<img src="{{ Storage::url($darkLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto inline-block']) }}>
@else
<span {{ $attributes->merge(['class' => 'inline-flex size-9 items-center justify-center rounded-md border border-primary/40 bg-primary/10 text-sm font-bold text-primary shadow-[0_10px_30px_rgb(37_99_235/0.18)]']) }}>VC</span>
@endif
