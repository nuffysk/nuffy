# Deploy Ňuffy na DigitalOcean

## 1) Droplet
- **Image:** Ubuntu 24.04 LTS
- **Veľkosť:** 2 GB RAM / 1 vCPU stačí ($12/mes); 1 GB ($6/mes) tiež funguje na začiatok
- **Region:** Frankfurt (FRA1) — najbližšie k SK
- **SSH key:** pridaj svoj
- **Hostname:** `nuffy`

## 2) Prvotné nastavenie servera
```bash
ssh root@<DROPLET_IP>

# Vytvor non-root user
adduser deploy
usermod -aG sudo deploy
rsync --archive --chown=deploy:deploy ~/.ssh /home/deploy

# Firewall
ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw --force enable

# Update + balíky
apt update && apt upgrade -y
apt install -y nginx mysql-server php8.3 php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-bcmath php8.3-gd php8.3-intl php8.3-sqlite3 unzip git certbot python3-certbot-nginx

# Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Node (pre Vite build)
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs

# MySQL
mysql_secure_installation
```

## 3) Databáza
```bash
sudo mysql
```
```sql
CREATE DATABASE nuffy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'nuffy'@'localhost' IDENTIFIED BY '<silne-heslo>';
GRANT ALL PRIVILEGES ON nuffy.* TO 'nuffy'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## 4) Aplikácia
```bash
sudo mkdir -p /var/www/nuffy
sudo chown -R deploy:www-data /var/www/nuffy
sudo chmod -R 775 /var/www/nuffy

su - deploy
cd /var/www/nuffy
git clone <REPO_URL> .

composer install --no-dev --optimize-autoloader
npm ci && npm run build

cp deploy/.env.production.example .env
nano .env   # vyplň DB heslo, MAIL_*, atď.
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=LearnTopicsSeeder
php artisan storage:link

# Vytvor admin účet pre Orchid panel
php artisan orchid:admin admin admin@nuffy.sk <silne-heslo>

# Permissions
sudo chown -R deploy:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

## 5) Nginx + SSL
```bash
sudo cp /var/www/nuffy/deploy/nginx-nuffy.conf /etc/nginx/sites-available/nuffy
sudo ln -s /etc/nginx/sites-available/nuffy /etc/nginx/sites-enabled/
sudo rm /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx

# SSL (po nastavení DNS A-record na IP dropletu)
sudo certbot --nginx -d nuffy.sk -d www.nuffy.sk
```

## 6) DNS
V DigitalOcean (alebo u registrátora domény) nastav:
- **A** `@` → IP dropletu
- **A** `www` → IP dropletu

## 7) Cache + opt
```bash
cd /var/www/nuffy
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## 8) Cron (Laravel scheduler)
```bash
crontab -e -u deploy
```
Pridaj:
```
* * * * * cd /var/www/nuffy && php artisan schedule:run >> /dev/null 2>&1
```

## 9) Queue worker (voliteľné — pre maily)
```bash
sudo nano /etc/systemd/system/nuffy-queue.service
```
```ini
[Unit]
Description=Nuffy queue worker
After=network.target

[Service]
Type=simple
User=deploy
WorkingDirectory=/var/www/nuffy
ExecStart=/usr/bin/php artisan queue:work --sleep=3 --tries=3 --max-time=3600
Restart=always

[Install]
WantedBy=multi-user.target
```
```bash
sudo systemctl enable nuffy-queue
sudo systemctl start nuffy-queue
```

## 10) Ďalšie deploye
Na servery:
```bash
cd /var/www/nuffy
bash deploy/deploy.sh
```

## Smoke test po nasadení
- `https://nuffy.sk/` — landing page
- `https://nuffy.sk/register` — registrácia
- `https://nuffy.sk/admin/login` — Orchid admin
- `https://nuffy.sk/learn` — vzdelávacie články
- `https://nuffy.sk/places` — miesta

## Zálohy
```bash
# Denná záloha DB do /var/backups/nuffy
sudo nano /etc/cron.daily/nuffy-backup
```
```bash
#!/bin/bash
mkdir -p /var/backups/nuffy
mysqldump -u nuffy -p'<heslo>' nuffy | gzip > /var/backups/nuffy/$(date +%F).sql.gz
find /var/backups/nuffy -mtime +14 -delete
```
```bash
sudo chmod +x /etc/cron.daily/nuffy-backup
```
