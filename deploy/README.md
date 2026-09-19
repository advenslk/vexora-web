# Lunar Hosting — VPS deployment

Target URL: https://lunar.arvex.host

## 1. DNS

Create an A record:

- Name: `lunar`
- Target: your VPS public IPv4
- Proxy/CDN: enabled if your DNS provider supports it

Wait until DNS resolves to the VPS.

## 2. Clone the application

On the VPS:

```bash
sudo mkdir -p /opt/lunar-hosting
sudo chown -R "$USER":"$USER" /opt/lunar-hosting
git clone https://github.com/advenslk/vexora-web.git /opt/lunar-hosting
cd /opt/lunar-hosting
```

For an existing checkout, use:

```bash
cd /opt/lunar-hosting
git pull --ff-only origin main
```

## 3. Configure production environment

```bash
cp .env.example .env
nano .env
```

Set at minimum:

```env
APP_URL=https://lunar.arvex.host
APP_ENV=production
APP_DEBUG=false

DB_PASSWORD=CHANGE_ME
DB_ROOT_PASSWORD=CHANGE_ME

APP_PORT=8080
```

Use strong, unique database passwords. Do not commit `.env`.

## 4. Build and start

```bash
docker compose up -d --build
docker compose ps
docker compose logs --tail=100 app
```

The application container listens on port 80 internally and is published on host port 8080.

## 5. Reverse proxy

Install Nginx on the VPS if it is not already installed:

```bash
sudo apt update
sudo apt install -y nginx
```

Copy the included config:

```bash
sudo cp deploy/nginx/lunar.arvex.host.conf /etc/nginx/sites-available/lunar.arvex.host
sudo ln -s /etc/nginx/sites-available/lunar.arvex.host /etc/nginx/sites-enabled/lunar.arvex.host
sudo nginx -t
sudo systemctl reload nginx
```

If another site already owns the default server, remove or disable the conflicting default configuration.

## 6. HTTPS

After DNS points to the VPS and HTTP works, install Certbot:

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d lunar.arvex.host
```

Choose the HTTP-to-HTTPS redirect when prompted.

Verify renewal:

```bash
sudo certbot renew --dry-run
```

## 7. First application check

```bash
curl -I http://127.0.0.1:8080
curl -I https://lunar.arvex.host
docker compose ps
docker compose logs --tail=100 app
```

The public site should be served through Laravel's application container, with Nginx providing the public HTTPS endpoint.

## 8. Updates

```bash
cd /opt/lunar-hosting
git pull --ff-only origin main
docker compose up -d --build
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan migrate --force
docker compose restart app
```

For production, take a database backup before migrations that modify billing, invoices, services or infrastructure state.
