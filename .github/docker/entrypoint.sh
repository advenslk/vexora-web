#!/bin/ash
set -eu

mkdir -p     /app/var     /app/storage/framework/cache     /app/storage/framework/sessions     /app/storage/framework/views     /app/storage/logs     /app/bootstrap/cache

chown -R nginx:nginx     /app/var     /app/storage     /app/bootstrap/cache

chmod -R u+rwX,go+rX     /app/var     /app/storage     /app/bootstrap/cache

# APP_KEY is a deployment secret. Prefer the externally supplied value, but
# persist the generated/existing value in the application environment so both
# CLI and PHP-FPM workers see the exact same key.
if [ -z "${APP_KEY:-}" ]; then
    if [ -f /app/var/.env ]; then
        APP_KEY="$(sed -n 's/^APP_KEY=//p' /app/var/.env | head -n1)"
    fi

    if [ -z "${APP_KEY:-}" ]; then
        php /app/artisan key:generate --show --no-ansi > /tmp/lunar-key
        APP_KEY="$(cat /tmp/lunar-key)"
        rm -f /tmp/lunar-key
    fi
fi

export APP_KEY

# Keep the runtime key available to Laravel's dotenv loader as a fallback.
# The file is generated at runtime and is never committed to Git.
umask 077
printf 'APP_KEY=%s\n' "${APP_KEY}" > /app/.env
printf 'APP_KEY=%s\n' "${APP_KEY}" > /app/var/.env
chmod 600 /app/.env /app/var/.env

until nc -z "${DB_HOST:-mariadb}" "${DB_PORT:-3306}" 2>/dev/null; do
    sleep 2
done

php /app/artisan storage:link --force >/dev/null 2>&1 || true

# Fail fast instead of starting PHP-FPM with a broken Laravel encryption setup.
php /app/artisan tinker --execute='if (!config("app.key")) { exit(1); }' --no-ansi >/dev/null

if [ "${LUNAR_AUTO_MIGRATE:-true}" = "true" ]; then
    php /app/artisan migrate --force --no-interaction
fi

exec "$@"