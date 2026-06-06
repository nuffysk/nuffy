#!/usr/bin/env bash
set -euo pipefail

# Run this on the DigitalOcean droplet from /var/www/nuffy
# Pulls the latest code, installs deps, migrates DB, rebuilds assets, restarts queue.

cd /var/www/nuffy

echo "→ Pulling latest"
git pull --ff-only

echo "→ Composer install (no-dev)"
composer install --no-dev --optimize-autoloader --no-interaction

echo "→ NPM build"
npm ci
npm run build

echo "→ Migrating DB"
php artisan migrate --force

echo "→ Caching config/routes/views"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "→ Storage link"
php artisan storage:link --force || true

echo "→ Restarting queue + reloading PHP-FPM"
php artisan queue:restart || true
sudo systemctl reload php8.3-fpm

echo "✓ Deploy complete"
