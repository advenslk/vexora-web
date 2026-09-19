<div id="root"></div>

<script>
    window.vexoraPaymenterRoutes = {
        gameServers: @json(route('category.show', ['category' => 'budget-game-hosting'])),
        premiumHosting: @json(route('category.show', ['category' => 'premium-game-hosting'])),
        botHosting: @json(route('category.show', ['category' => 'discord-bot-hosting'])),
        store: @json(route('category.show', ['category' => 'budget-game-hosting'])),
        login: @json(route('login')),
        register: @json(route('register')),
        dashboard: @json(route('dashboard')),
        discord: 'https://discord.gg/eRxmF3NHpf'
    };
</script>
<script type="module" crossorigin src="{{ asset('site-assets/index-uWja_BUA.js') }}?v=20260913-exact"></script>
