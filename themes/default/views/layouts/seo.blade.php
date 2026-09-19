@php
    $brandName = 'Vexora Cloud';
    $founderName = 'Ayush Kumar Jha';
    $publicBaseUrl = 'https://vexora.cloud';
    $requestPath = request()->getPathInfo() === '/' ? '' : request()->getPathInfo();
    $canonicalUrl = $publicBaseUrl . $requestPath;
    $defaultDescription = 'Vexora Cloud is a premium cloud hosting and billing platform founded by Ayush Kumar Jha, offering Minecraft server hosting in India, Discord bot hosting, NVMe storage, DDoS-protected infrastructure and 24/7 support.';
    $seoDescription = (isset($description) && $description) ? $description : $defaultDescription;
    $seoImage = (isset($image) && $image) ? $image : asset('assets/vexora-logo-new.png');
    $isHome = request()->routeIs('home');
    $seoTitle = $isHome
        ? 'Vexora Cloud - Minecraft Server Hosting India, Discord Bot Hosting & Cloud Billing'
        : trim($brandName . (isset($title) && $title ? ' - ' . $title : ''));
    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => $publicBaseUrl . '/#organization',
                'name' => $brandName,
                'url' => $publicBaseUrl,
                'logo' => $publicBaseUrl . '/assets/vexora-logo-new.png',
                'founder' => [
                    '@type' => 'Person',
                    'name' => $founderName,
                ],
                'sameAs' => [
                    'https://discord.gg/eRxmF3NHpf',
                ],
                'description' => $defaultDescription,
            ],
            [
                '@type' => 'WebSite',
                '@id' => $publicBaseUrl . '/#website',
                'url' => $publicBaseUrl,
                'name' => $brandName,
                'publisher' => [
                    '@id' => $publicBaseUrl . '/#organization',
                ],
                'inLanguage' => 'en-IN',
            ],
            [
                '@type' => 'WebPage',
                '@id' => $canonicalUrl . '#webpage',
                'url' => $canonicalUrl,
                'name' => $seoTitle,
                'description' => $seoDescription,
                'isPartOf' => [
                    '@id' => $publicBaseUrl . '/#website',
                ],
                'about' => [
                    '@id' => $publicBaseUrl . '/#organization',
                ],
                'inLanguage' => 'en-IN',
            ],
        ],
    ];
@endphp

<meta name="title" content="{{ $seoTitle }}">
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="Vexora Cloud, Vexora Cloud founder, Ayush Kumar Jha, Minecraft server hosting India, Discord bot hosting India, game server hosting India, NVMe hosting, DDoS protected hosting, Pterodactyl hosting">
<meta name="author" content="Vexora Cloud">
<meta name="robots" content="{{ request()->routeIs('dashboard', 'account*', 'invoices*', 'services*', 'tickets*', 'cart', 'login', 'register', 'password.*') ? 'noindex, nofollow' : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' }}">
<meta name="googlebot" content="{{ request()->routeIs('dashboard', 'account*', 'invoices*', 'services*', 'tickets*', 'cart', 'login', 'register', 'password.*') ? 'noindex, nofollow' : 'index, follow' }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

<meta property="og:locale" content="en_IN">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $brandName }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:image" content="{{ $seoImage }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">

<script type="application/ld+json">@json($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
