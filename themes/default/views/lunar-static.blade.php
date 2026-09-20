<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#05070b">
    <meta name="color-scheme" content="dark">
    <meta name="robots" content="index,follow,max-image-preview:large">
    <link rel="canonical" href="{{ rtrim(config('app.url'), '/') }}/">
    <link rel="icon" href="/assets/vexora-logo.png">
    <title>Lunar Hosting — Infrastructure without the friction</title>
    <meta name="description" content="Lunar Hosting provides VPS, VDS, game and bot hosting with a modern customer platform, automated billing and real infrastructure provisioning.">
    <meta property="og:site_name" content="Lunar Hosting">
    <meta property="og:title" content="Lunar Hosting — Infrastructure without the friction">
    <meta property="og:description" content="Modern hosting infrastructure with a clean customer experience, automated billing and real provisioning.">
    <meta property="og:url" content="{{ rtrim(config('app.url'), '/') }}/">
    <meta property="og:image" content="{{ rtrim(config('app.url'), '/') }}/assets/vexora-brand-hero.png">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">
    {
        "@@context":"https://schema.org",
        "@@graph":[
            {
                "@@type":"Organization",
                "@@id":"{{ rtrim(config('app.url'), '/') }}/#organization",
                "name":"Lunar Hosting",
                "url":"{{ rtrim(config('app.url'), '/') }}/",
                "logo":"{{ rtrim(config('app.url'), '/') }}/assets/vexora-logo.png"
            },
            {
                "@@type":"WebSite",
                "@@id":"{{ rtrim(config('app.url'), '/') }}/#website",
                "name":"Lunar Hosting",
                "url":"{{ rtrim(config('app.url'), '/') }}/"
            }
        ]
    }
    </script>
    <style>
        :root {
            --bg: #05070b;
            --panel: rgba(13, 17, 26, .72);
            --panel-solid: #0d111a;
            --line: rgba(255,255,255,.09);
            --text: #f6f8fb;
            --muted: #9aa5b5;
            --accent: #8b7cff;
            --accent-2: #5eead4;
            --max: 1180px;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 15% 0%, rgba(139,124,255,.18), transparent 30rem),
                radial-gradient(circle at 85% 10%, rgba(94,234,212,.08), transparent 26rem),
                var(--bg);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        .shell { width: min(calc(100% - 40px), var(--max)); margin: 0 auto; }
        .nav-wrap { position: fixed; inset: 16px 0 auto; z-index: 50; }
        nav {
            display: flex; align-items: center; justify-content: space-between; gap: 24px;
            min-height: 66px; padding: 0 14px 0 18px;
            border: 1px solid var(--line); border-radius: 20px;
            background: rgba(7,9,14,.72); backdrop-filter: blur(20px);
            box-shadow: 0 18px 50px rgba(0,0,0,.28);
        }
        .brand { display: inline-flex; align-items: center; gap: 11px; font-weight: 750; letter-spacing: -.03em; }
        .brand img { width: 34px; height: 34px; object-fit: contain; }
        .brand span { font-size: 16px; }
        .links { display: flex; align-items: center; gap: 4px; }
        .links a { padding: 10px 12px; border-radius: 11px; color: #b6bfcc; font-size: 13px; font-weight: 600; }
        .links a:hover { color: white; background: rgba(255,255,255,.06); }
        .actions { display: flex; gap: 8px; align-items: center; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            min-height: 42px; padding: 0 16px; border-radius: 12px;
            border: 1px solid var(--line); font-size: 13px; font-weight: 700;
            transition: transform .2s ease, border-color .2s ease, background .2s ease;
        }
        .btn:hover { transform: translateY(-1px); border-color: rgba(255,255,255,.18); }
        .btn-ghost { background: rgba(255,255,255,.035); color: #d7dde7; }
        .btn-primary { color: #08090d; border-color: transparent; background: linear-gradient(135deg,#a79bff,#70e9d8); box-shadow: 0 12px 30px rgba(139,124,255,.22); }
        .hero { position: relative; padding: 190px 0 110px; overflow: hidden; }
        .hero-grid { display: grid; grid-template-columns: 1.05fr .95fr; gap: 70px; align-items: center; }
        .eyebrow { display: inline-flex; align-items: center; gap: 8px; padding: 7px 10px; border: 1px solid var(--line); border-radius: 999px; color: #bdc6d3; background: rgba(255,255,255,.035); font-size: 11px; font-weight: 750; text-transform: uppercase; letter-spacing: .11em; }
        .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--accent-2); box-shadow: 0 0 18px rgba(94,234,212,.7); }
        h1 { margin: 20px 0 18px; max-width: 760px; font-size: clamp(48px, 7vw, 84px); line-height: .97; letter-spacing: -.065em; }
        .gradient { background: linear-gradient(120deg,#fff 20%,#a79bff 65%,#70e9d8); -webkit-background-clip:text; background-clip:text; color: transparent; }
        .lead { max-width: 640px; margin: 0; color: var(--muted); font-size: 17px; line-height: 1.75; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 30px; }
        .micro { display: flex; flex-wrap: wrap; gap: 16px; margin-top: 25px; color: #788393; font-size: 12px; }
        .micro span { display: inline-flex; align-items: center; gap: 7px; }
        .micro i { width: 5px; height: 5px; border-radius: 50%; background: #687386; }
        .visual { position: relative; min-height: 470px; display: grid; place-items: center; }
        .orb { position: absolute; width: 380px; height: 380px; border-radius: 50%; background: radial-gradient(circle,rgba(139,124,255,.22),rgba(139,124,255,0) 68%); filter: blur(5px); }
        .terminal {
            position: relative; width: min(100%, 520px); overflow: hidden;
            border: 1px solid rgba(255,255,255,.12); border-radius: 24px;
            background: linear-gradient(145deg,rgba(19,24,36,.95),rgba(8,11,17,.9));
            box-shadow: 0 35px 90px rgba(0,0,0,.5), 0 0 80px rgba(139,124,255,.10);
            transform: perspective(1000px) rotateY(-7deg) rotateX(3deg);
        }
        .terminal-head { display:flex; justify-content:space-between; align-items:center; padding: 14px 17px; border-bottom:1px solid var(--line); }
        .traffic { display:flex; gap:6px; } .traffic b { width:7px; height:7px; border-radius:50%; background:#657083; }
        .terminal-label { color:#737f91; font-size:10px; letter-spacing:.12em; text-transform:uppercase; }
        .terminal-body { padding: 22px; }
        .server-card { padding: 18px; border:1px solid var(--line); border-radius:18px; background:rgba(255,255,255,.025); }
        .server-top { display:flex; align-items:center; justify-content:space-between; gap:15px; }
        .server-name { font-size:14px; font-weight:750; } .server-meta { color:#6f7a8b; font-size:11px; margin-top:5px; }
        .status { display:inline-flex; align-items:center; gap:6px; color:#9ee9d9; font-size:11px; font-weight:700; }
        .status:before { content:""; width:6px; height:6px; border-radius:50%; background:#5eead4; box-shadow:0 0 12px #5eead4; }
        .metrics { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin-top:13px; }
        .metric { padding:11px; border-radius:12px; background:rgba(255,255,255,.035); }
        .metric small { display:block; color:#6f7a8b; font-size:9px; text-transform:uppercase; letter-spacing:.1em; }
        .metric strong { display:block; margin-top:5px; font-size:13px; }
        .line { height:1px; margin:15px 0; background:var(--line); }
        .log { display:grid; gap:8px; color:#7e8999; font: 11px/1.5 ui-monospace, SFMono-Regular, Menlo, monospace; }
        .log b { color:#b7c0cd; font-weight:500; }
        section { padding: 95px 0; }
        .section-head { display:flex; justify-content:space-between; gap:35px; align-items:end; margin-bottom:30px; }
        .kicker { color:#7f8a9c; font-size:11px; font-weight:800; letter-spacing:.13em; text-transform:uppercase; }
        h2 { margin:9px 0 0; font-size:clamp(30px,4vw,48px); letter-spacing:-.045em; }
        .section-copy { max-width:470px; color:var(--muted); line-height:1.7; font-size:14px; }
        .cards { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; }
        .card { padding:24px; min-height:220px; border:1px solid var(--line); border-radius:20px; background:linear-gradient(150deg,rgba(255,255,255,.045),rgba(255,255,255,.018)); transition:transform .25s ease,border-color .25s ease,background .25s ease; }
        .card:hover { transform:translateY(-4px); border-color:rgba(167,155,255,.28); background:linear-gradient(150deg,rgba(139,124,255,.08),rgba(255,255,255,.018)); }
        .icon { width:40px; height:40px; display:grid; place-items:center; border-radius:12px; background:rgba(139,124,255,.10); border:1px solid rgba(139,124,255,.16); color:#b7adff; font-weight:800; }
        .card h3 { margin:24px 0 8px; font-size:16px; letter-spacing:-.02em; } .card p { margin:0; color:#7f8a99; font-size:13px; line-height:1.65; }
        .feature { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .feature-box { padding:32px; min-height:250px; border:1px solid var(--line); border-radius:22px; background:rgba(255,255,255,.025); }
        .feature-box h3 { margin:0 0 10px; font-size:21px; } .feature-box p { margin:0; max-width:520px; color:#8792a1; line-height:1.7; font-size:14px; }
        .ticks { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:22px; } .ticks div { color:#b5bfcc; font-size:12px; } .ticks span { color:#6ee7d7; margin-right:7px; }
        .cta { padding:55px; border:1px solid rgba(167,155,255,.17); border-radius:28px; background:radial-gradient(circle at 75% 30%,rgba(112,233,216,.08),transparent 35%),linear-gradient(135deg,rgba(139,124,255,.11),rgba(255,255,255,.025)); }
        .cta h2 { max-width:650px; } .cta p { color:#8d98a8; max-width:600px; line-height:1.7; }
        footer { padding:30px 0 45px; border-top:1px solid var(--line); color:#6e7887; font-size:12px; }
        .footer-inner { display:flex; justify-content:space-between; gap:20px; align-items:center; } .footer-links { display:flex; gap:16px; } .footer-links a:hover { color:#dce1e8; }
        @@media (max-width: 900px) {
            .links { display:none; } .hero-grid,.feature { grid-template-columns:1fr; } .visual { min-height:390px; }
            .cards { grid-template-columns:1fr 1fr; } .section-head { align-items:start; flex-direction:column; }
            .hero { padding-top:145px; } h1 { font-size:clamp(48px,13vw,72px); }
        }
        @@media (max-width: 560px) {
            .shell { width:min(calc(100% - 24px),var(--max)); } nav { min-height:60px; padding-left:12px; }
            .actions .btn-ghost { display:none; } .cards { grid-template-columns:1fr; } .hero { padding-bottom:55px; }
            section { padding:65px 0; } .cta { padding:28px; } .ticks { grid-template-columns:1fr; } .visual { min-height:330px; }
            .terminal { transform:none; } .terminal-body { padding:15px; } .metrics { grid-template-columns:1fr; }
            .footer-inner { align-items:flex-start; flex-direction:column; }
        }
    </style>
<style>
:root{--bg:#05070b!important;--line:rgba(255,255,255,.075)!important;--accent:#78a9ff!important;--accent-2:#63e2d0!important;--max:1280px!important}
body{background:#05070b!important;background-image:radial-gradient(900px 500px at 82% -8%,rgba(75,125,255,.18),transparent 65%),radial-gradient(700px 450px at 5% 12%,rgba(70,220,195,.07),transparent 65%)!important}
body:before{content:"";position:fixed;inset:0;pointer-events:none;opacity:.18;background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);background-size:72px 72px;mask-image:linear-gradient(#000,transparent 80%);z-index:-1}
.nav-wrap{top:18px!important}.nav-wrap nav{max-width:1280px;margin:auto;min-height:70px!important;border-radius:18px!important;background:rgba(7,10,15,.78)!important;border-color:rgba(255,255,255,.12)!important;box-shadow:0 22px 70px rgba(0,0,0,.34)!important}
.brand img{width:36px!important;height:36px!important}.brand span{font-size:17px!important}.links a{font-size:12px!important;color:#9da8b8!important}.links a:hover{color:#fff!important;background:rgba(255,255,255,.06)!important}
.btn{min-height:44px!important;border-radius:12px!important}.btn-primary{background:linear-gradient(135deg,#b5ccff,#69e2d0)!important;box-shadow:0 14px 36px rgba(70,130,255,.2)!important}
.hero{padding:190px 0 105px!important}.hero-grid{max-width:1280px!important;margin:auto!important;gap:65px!important}.eyebrow{background:rgba(255,255,255,.035)!important;border-color:rgba(255,255,255,.1)!important}
h1{font-size:clamp(52px,6.8vw,92px)!important;line-height:.94!important;letter-spacing:-.07em!important}.lead{font-size:17px!important;color:#919cac!important}
.visual{min-height:500px!important}.terminal{border-radius:24px!important;background:linear-gradient(145deg,#111824,#070a10)!important;box-shadow:0 45px 110px rgba(0,0,0,.58),0 0 100px rgba(70,120,255,.1)!important}
section{padding:105px 0!important}.section-head{margin-bottom:34px!important}.kicker{color:#708097!important}.section-copy{color:#8b96a6!important}
.cards{gap:14px!important}.card{min-height:235px!important;padding:26px!important;border-radius:20px!important;background:linear-gradient(145deg,rgba(255,255,255,.045),rgba(255,255,255,.015))!important}
.card:hover{transform:translateY(-6px)!important;border-color:rgba(120,169,255,.32)!important;box-shadow:0 25px 70px rgba(0,0,0,.24)!important}.icon{border-radius:13px!important;background:rgba(90,140,255,.08)!important;color:#a7c5ff!important}
.feature{gap:14px!important}.feature-box{border-radius:21px!important;background:rgba(255,255,255,.022)!important;border-color:rgba(255,255,255,.075)!important;padding:34px!important}
.cta{border-radius:26px!important;padding:62px!important;background:radial-gradient(600px 260px at 85% 10%,rgba(99,226,208,.08),transparent 70%),linear-gradient(135deg,rgba(70,120,255,.13),rgba(255,255,255,.02))!important}
footer{border-top-color:rgba(255,255,255,.07)!important}
@media(max-width:900px){.nav-wrap{top:10px!important}.hero{padding-top:145px!important}.hero-grid{gap:30px!important}.visual{min-height:390px!important}.cards{grid-template-columns:1fr 1fr!important}}
@media(max-width:560px){.shell{width:min(calc(100% - 24px),var(--max))!important}.hero{padding-top:135px!important}.cards{grid-template-columns:1fr!important}.cta{padding:30px 24px!important}.visual{min-height:330px!important}.terminal{transform:none!important}}
</style></head>
<body>
<div class="nav-wrap">
    <div class="shell">
        <nav>
            <a class="brand" href="/">
                <img src="/assets/vexora-logo.png" alt="Lunar Hosting">
                <span>Lunar Hosting</span>
            </a>
            <div class="links">
                <a href="#services">Services</a>
                <a href="#platform">Platform</a>
                <a href="#support">Support</a>
            </div>
            <div class="actions">
                <a class="btn btn-ghost" href="/login">Sign in</a>
                <a class="btn btn-primary" href="/products">Explore plans</a>
            </div>
        </nav>
    </div>
</div>

<main>
    <section class="hero">
        <div class="shell hero-grid">
            <div>
                <div class="eyebrow"><span class="dot"></span> Cloud infrastructure, simplified</div>
                <h1>Infrastructure that gets out of the <span class="gradient">way.</span></h1>
                <p class="lead">Modern VPS, VDS, game and bot hosting with automated billing, real infrastructure provisioning and a customer experience designed to stay out of your way.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="/products">View available plans <span>→</span></a>
                    <a class="btn btn-ghost" href="#platform">See how it works</a>
                </div>
                <div class="micro">
                    <span><i></i> Automated billing</span>
                    <span><i></i> Real provisioning</span>
                    <span><i></i> Customer dashboard</span>
                </div>
            </div>
            <div class="visual" aria-hidden="true">
                <div class="orb"></div>
                <div class="terminal">
                    <div class="terminal-head"><div class="traffic"><b></b><b></b><b></b></div><div class="terminal-label">lunar / infrastructure</div></div>
                    <div class="terminal-body">
                        <div class="server-card">
                            <div class="server-top">
                                <div><div class="server-name">Your infrastructure</div><div class="server-meta">Managed from one customer panel</div></div>
                                <div class="status">Operational</div>
                            </div>
                            <div class="metrics">
                                <div class="metric"><small>Provisioning</small><strong>Automated</strong></div>
                                <div class="metric"><small>Billing</small><strong>Synced</strong></div>
                                <div class="metric"><small>Access</small><strong>24 / 7</strong></div>
                            </div>
                            <div class="line"></div>
                            <div class="log">
                                <div><b>01</b>  payment confirmed → invoice paid</div>
                                <div><b>02</b>  provisioning job → queued</div>
                                <div><b>03</b>  infrastructure → ready</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="shell">
            <div class="section-head">
                <div><div class="kicker">What you can run</div><h2>The right infrastructure for your workload.</h2></div>
                <p class="section-copy">Choose the infrastructure you actually need. Plans and availability are managed from the live product catalogue — no hard-coded pricing on the landing page.</p>
            </div>
            <div class="cards">
                <article class="card"><div class="icon">V</div><h3>VPS</h3><p>Flexible virtual servers for applications, development environments, websites and private workloads.</p></article>
                <article class="card"><div class="icon">G</div><h3>Game hosting</h3><p>Game-focused server plans with a simple customer experience from checkout to deployment.</p></article>
                <article class="card"><div class="icon">B</div><h3>Bot hosting</h3><p>Run Discord bots and lightweight services with a clean billing and service lifecycle.</p></article>
                <article class="card"><div class="icon">D</div><h3>VDS</h3><p>Dedicated-style virtual resources for workloads that need more predictable capacity.</p></article>
            </div>
        </div>
    </section>

    <section id="platform">
        <div class="shell">
            <div class="section-head">
                <div><div class="kicker">The platform</div><h2>From order to running server.</h2></div>
                <p class="section-copy">Lunar is designed around real service state. Payment confirmation can trigger queued provisioning, and the customer panel reflects the resulting service lifecycle.</p>
            </div>
            <div class="feature">
                <div class="feature-box">
                    <h3>One customer experience</h3>
                    <p>Account, services, invoices, tickets and payments live in one place instead of being scattered across separate systems.</p>
                    <div class="ticks"><div><span>✓</span> Account & authentication</div><div><span>✓</span> Invoices & transactions</div><div><span>✓</span> Service lifecycle</div><div><span>✓</span> Support tickets</div></div>
                </div>
                <div class="feature-box">
                    <h3>Built for automation</h3>
                    <p>Queue-backed jobs separate billing events from infrastructure actions, so provisioning work can be retried safely instead of pretending a server exists.</p>
                    <div class="ticks"><div><span>✓</span> Payment verification</div><div><span>✓</span> Queued provisioning</div><div><span>✓</span> Retry-aware lifecycle</div><div><span>✓</span> Persistent service state</div></div>
                </div>
            </div>
        </div>
    </section>

    <section id="support">
        <div class="shell">
            <div class="cta">
                <div class="kicker">Ready when you are</div>
                <h2>Deploy with confidence. Manage everything in one place.</h2>
                <p>Browse the current catalogue, create an account and manage your infrastructure from the Lunar Hosting panel.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="/products">Browse plans →</a>
                    <a class="btn btn-ghost" href="/register">Create account</a>
                </div>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="shell footer-inner">
        <div>© {{ date('Y') }} Lunar Hosting. All rights reserved.</div>
        <div class="footer-links">
            <a href="/terms">Terms</a>
            <a href="/refund-policy">Refund policy</a>
            <a href="/support">Support</a>
        </div>
    </div>
</footer>
</body>
</html>
