# Lunar Hosting

Lunar Hosting is a self-hosted hosting billing and provisioning platform built on Laravel. It is based on the open-source Paymenter codebase and retains the applicable MIT licensing and upstream attribution.

## Production architecture

- Laravel 12 / PHP 8.3+
- Filament 5
- MariaDB
- Redis
- Queue workers for asynchronous provisioning
- Extension-based payment gateways
- Extension-based infrastructure/server provisioning
- Docker Compose deployment
- Customer billing, invoices, services and support workflows

The platform is designed so that payment confirmation can trigger real service provisioning through the configured infrastructure extension. It does not rely on demo server states or fake payment success.

## Docker deployment

1. Copy the environment template:

```bash
cp .env.example .env
```

2. Set production values in `.env`, including:

- `APP_URL`
- `APP_KEY` (generated automatically on first container start if empty)
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `DB_ROOT_PASSWORD`
- `APP_PORT`

3. Start the production stack:

```bash
docker compose up -d --build
```

4. Check the containers:

```bash
docker compose ps
docker compose logs -f app
```

The application container waits for MariaDB, runs pending migrations when `LUNAR_AUTO_MIGRATE=true`, and starts PHP-FPM, Nginx, the Redis queue worker and Laravel scheduler under Supervisor.

For a production installation, place the stack behind HTTPS using a reverse proxy or load balancer and configure `APP_URL` to the public HTTPS URL.

## Payments and provisioning

Payment gateways must be configured in the admin panel with their real credentials and webhook endpoints.

The payment lifecycle is:

1. Customer creates an order/invoice.
2. Customer completes payment through a configured gateway.
3. Gateway webhook is authenticated and processed.
4. The payment is recorded against the invoice.
5. A paid invoice is processed idempotently.
6. Service provisioning/renewal is dispatched to the queue.
7. The configured server/infrastructure extension creates or updates the real service.
8. The service becomes active only after successful provisioning.

Do not mark an invoice as paid manually in production unless that is an intentional administrative action.

## Testing

Run the project checks locally with:

```bash
composer validate
composer install
vendor/bin/pint --test
vendor/bin/phpunit --testsuite "Lunar Hosting"
```

GitHub Actions runs Composer validation, PHP syntax checks, formatting checks and the PHPUnit suite on pushes and pull requests targeting `main`.

## License

This project remains licensed under the MIT License in accordance with the upstream Paymenter license and the repository's applicable copyright and attribution terms.
