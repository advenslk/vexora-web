<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#06070a" />
    <meta name="color-scheme" content="dark" />
    <meta name="robots" content="index,follow,max-image-preview:large" />
    <link rel="canonical" href="{{ rtrim(config('app.url'), '/') }}/" />
    <link rel="icon" href="/assets/vexora-logo.png" />
    <title>Lunar Hosting — Game Servers, VPS, VDS & Cloud Hosting</title>
    <meta name="description" content="Affordable game server hosting from Starting at your configured plan price, free hosting, KVM VPS, VDS and bot hosting from Lunar Hosting. Fast NVMe infrastructure and protected deployments." />
    <meta property="og:site_name" content="Lunar Hosting" />
    <meta property="og:title" content="Lunar Hosting — Game Servers, VPS, VDS & Cloud Hosting" />
    <meta property="og:description" content="Affordable game servers from Starting at your configured plan price, free hosting, KVM VPS, VDS and bot hosting powered by fast NVMe infrastructure." />
    <meta property="og:url" content="{{ rtrim(config('app.url'), '/') }}/" />
    <meta property="og:image" content="{{ rtrim(config('app.url'), '/') }}/assets/vexora-brand-hero.png" />
    <meta property="og:image:alt" content="Lunar Hosting hosting infrastructure" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Lunar Hosting — Affordable Game Servers & VPS Hosting" />
    <meta name="twitter:description" content="Game server hosting from Starting at your configured plan price, free hosting, KVM VPS, VDS and bot hosting." />
    <meta name="twitter:image" content="{{ rtrim(config('app.url'), '/') }}/assets/vexora-brand-hero.png" />
    <script type="application/ld+json">
      @verbatim
      {
        "@context": "https://schema.org",
        "@graph": [
          {
            "@type": "Organization",
            "@id": "{{ rtrim(config('app.url'), '/') }}/#organization",
            "name": "Lunar Hosting",
            "url": "{{ rtrim(config('app.url'), '/') }}/",
            "logo": "{{ rtrim(config('app.url'), '/') }}/assets/vexora-logo.png",
            "sameAs": ["https://discord.gg/eRxmF3NHpf"]
          },
          {
            "@type": "WebSite",
            "@id": "{{ rtrim(config('app.url'), '/') }}/#website",
            "url": "{{ rtrim(config('app.url'), '/') }}/",
            "name": "Lunar Hosting",
            "publisher": { "@id": "{{ rtrim(config('app.url'), '/') }}/#organization" }
          }
        ]
      }
      @endverbatim
    </script>
    <script>
      (function () {
        var originalRemoveChild = Node.prototype.removeChild;
        Node.prototype.removeChild = function (child) {
          if (child && child.parentNode !== this) {
            return child;
          }

          return originalRemoveChild.call(this, child);
        };
      })();
    </script>
    <script type="module" crossorigin src="/site-assets/index-uWja_BUA.js"></script>
    <link rel="stylesheet" crossorigin href="/site-assets/index-BL5plpFo.css?v=20260913-exact">
  </head>
  <body>
    <div id="root"></div>
  </body>
</html>
