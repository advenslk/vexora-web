<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#06070a" />
    <meta name="color-scheme" content="dark" />
    <meta name="robots" content="index,follow,max-image-preview:large" />
    <link rel="canonical" href="https://{{ parse_url(config('app.url'), PHP_URL_HOST) }}/" />
    <link rel="icon" href="/assets/vexora-logo.png" />
    <title>Lunar Hosting — Game Servers, VPS, VDS & Cloud Hosting</title>
    <meta name="description" content="Affordable game server hosting from Starting at your configured plan price, free hosting, KVM VPS, VDS and bot hosting from Lunar Hosting. Fast NVMe infrastructure and protected deployments." />
    <meta property="og:site_name" content="Lunar Hosting" />
    <meta property="og:title" content="Lunar Hosting — Game Servers, VPS, VDS & Cloud Hosting" />
    <meta property="og:description" content="Affordable game servers from Starting at your configured plan price, free hosting, KVM VPS, VDS and bot hosting powered by fast NVMe infrastructure." />
    <meta property="og:url" content="https://{{ parse_url(config('app.url'), PHP_URL_HOST) }}/" />
    <meta property="og:image" content="https://{{ parse_url(config('app.url'), PHP_URL_HOST) }}/assets/vexora-brand-hero.png" />
    <meta property="og:image:alt" content="Lunar Hosting hosting infrastructure" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Lunar Hosting — Affordable Game Servers & VPS Hosting" />
    <meta name="twitter:description" content="Game server hosting from Starting at your configured plan price, free hosting, KVM VPS, VDS and bot hosting." />
    <meta name="twitter:image" content="https://{{ parse_url(config('app.url'), PHP_URL_HOST) }}/assets/vexora-brand-hero.png" />
    <script type="application/ld+json">
      @verbatim
      {
        "@context": "https://schema.org",
        "@graph": [
          {
            "@type": "Organization",
            "@id": "https://{{ parse_url(config('app.url'), PHP_URL_HOST) }}/#organization",
            "name": "Lunar Hosting",
            "url": "https://{{ parse_url(config('app.url'), PHP_URL_HOST) }}/",
            "logo": "https://{{ parse_url(config('app.url'), PHP_URL_HOST) }}/assets/vexora-logo.png",
            "founder": { "@type": "Person", "name": "Ayush Kumar Jha" },
            "sameAs": ["https://discord.gg/eRxmF3NHpf"]
          },
          {
            "@type": "WebSite",
            "@id": "https://{{ parse_url(config('app.url'), PHP_URL_HOST) }}/#website",
            "url": "https://{{ parse_url(config('app.url'), PHP_URL_HOST) }}/",
            "name": "Lunar Hosting",
            "publisher": { "@id": "https://{{ parse_url(config('app.url'), PHP_URL_HOST) }}/#organization" }
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
