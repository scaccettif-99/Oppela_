#!/usr/bin/env bash
# =============================================================================
#  Oppela!! - installazione completa su una Droplet DigitalOcean nuova
#  (Ubuntu 24.04 LTS). Da eseguire UNA VOLTA come root:
#
#     curl -fsSLo installa.sh https://raw.githubusercontent.com/scaccettif-99/Oppela_/main/deploy/installa-server.sh
#     bash installa.sh
#
#  Installa nginx, PHP 8.3, MySQL, Composer, Node 22; scarica il sito,
#  crea database e file .env, compila gli stili, esegue le migrazioni,
#  configura il caricamento foto fino a 15 MB e l'operazione pianificata
#  che elimina i venduti dopo 7 giorni.
# =============================================================================
set -euo pipefail

# provenienza del codice (repository pubblico su GitHub; si può cambiare con REPO=...)
REPO="${REPO:-https://github.com/scaccettif-99/Oppela_.git}"
APP_DIR="/var/www/oppela"
DB_NAME="oppela"
DB_USER="oppela"
PHP_VER="8.3"
IP_PUBBLICO="$(curl -fsS4 https://ifconfig.me || hostname -I | awk '{print $1}')"

passo() { echo -e "\n\033[1;33m==> $*\033[0m"; }

passo "Memoria di swap (evita blocchi durante la compilazione su Droplet piccole)"
if ! swapon --show | grep -q .; then
    fallocate -l 2G /swapfile && chmod 600 /swapfile && mkswap /swapfile && swapon /swapfile
    echo '/swapfile none swap sw 0 0' >> /etc/fstab
fi

passo "Pacchetti di sistema"
export DEBIAN_FRONTEND=noninteractive
# su una Droplet appena creata Ubuntu fa da solo i primi aggiornamenti: aspetto che finisca
cloud-init status --wait >/dev/null 2>&1 || true
apt_attendi() {
    local n=0
    while fuser /var/lib/dpkg/lock-frontend /var/lib/dpkg/lock /var/lib/apt/lists/lock >/dev/null 2>&1; do
        [ $((n % 6)) -eq 0 ] && echo "   (aggiornamenti automatici di Ubuntu in corso, attendo...)"
        n=$((n + 1)); sleep 10
    done
}
apt_attendi
apt-get -o DPkg::Lock::Timeout=600 update -y
apt-get -o DPkg::Lock::Timeout=600 install -y nginx mysql-server git unzip curl ufw cron \
    php${PHP_VER}-fpm php${PHP_VER}-cli php${PHP_VER}-mysql php${PHP_VER}-mbstring php${PHP_VER}-xml \
    php${PHP_VER}-curl php${PHP_VER}-zip php${PHP_VER}-gd php${PHP_VER}-intl php${PHP_VER}-bcmath

passo "Composer"
if ! command -v composer >/dev/null; then
    curl -fsSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

passo "Node.js 22 (serve solo per compilare gli stili)"
if ! command -v node >/dev/null || [ "$(node -v | cut -d. -f1 | tr -d v)" -lt 20 ]; then
    curl -fsSL https://deb.nodesource.com/setup_22.x | bash -
    apt-get -o DPkg::Lock::Timeout=600 install -y nodejs
fi

passo "Database MySQL"
DB_PASS="$(openssl rand -hex 16)"
mysql <<SQL
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
ALTER USER '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;
SQL

passo "Codice del sito"
if [ ! -d "${APP_DIR}/.git" ]; then
    git clone "${REPO}" "${APP_DIR}"
else
    git config --global --add safe.directory "${APP_DIR}" 2>/dev/null || true
    git -C "${APP_DIR}" pull --ff-only
fi
cd "${APP_DIR}"

passo "File .env di produzione"
imposta() { if grep -q "^$1=" .env; then sed -i "s|^$1=.*|$1=$2|" .env; else echo "$1=$2" >> .env; fi; }
if [ ! -f .env ]; then
    CODICE_INVITO="oppela-$(openssl rand -hex 3)"
    cp .env.example .env
    imposta APP_NAME '"Oppela!!"'
    imposta APP_ENV production
    imposta APP_DEBUG false
    imposta APP_URL "http://${IP_PUBBLICO}"
    imposta APP_LOCALE it
    imposta APP_FALLBACK_LOCALE it
    imposta APP_FAKER_LOCALE it_IT
    imposta LOG_LEVEL warning
    imposta DB_DATABASE "${DB_NAME}"
    imposta DB_USERNAME "${DB_USER}"
    imposta QUEUE_CONNECTION sync
    imposta MAIL_FROM_ADDRESS '"oppela.tr@gmail.com"'
    imposta CODICE_REGISTRAZIONE "${CODICE_INVITO}"
else
    CODICE_INVITO="$(grep '^CODICE_REGISTRAZIONE=' .env | cut -d= -f2)"
fi
imposta DB_PASSWORD "${DB_PASS}"   # password appena (ri)generata per l'utente MySQL

passo "Dipendenze PHP e compilazione stili"
export COMPOSER_ALLOW_SUPERUSER=1
composer install --no-dev --optimize-autoloader --no-interaction
grep -q '^APP_KEY=base64' .env || php artisan key:generate --force
npm ci --no-audit --no-fund
npm run build
rm -f public/hot

passo "Database: tabelle e contenuti iniziali (slide, loghi)"
php artisan migrate --force
php artisan storage:link || true

passo "Permessi"
chown -R www-data:www-data "${APP_DIR}"
find storage bootstrap/cache -type d -exec chmod 775 {} \;

passo "Cache di configurazione, rotte e pagine"
sudo -u www-data php artisan optimize

passo "PHP: foto dal telefono fino a 15 MB"
cat > /etc/php/${PHP_VER}/fpm/conf.d/99-oppela.ini <<INI
upload_max_filesize = 20M
post_max_size = 100M
memory_limit = 512M
max_file_uploads = 20
expose_php = Off
INI
systemctl restart php${PHP_VER}-fpm

passo "nginx"
sed "s|__APP_DIR__|${APP_DIR}|g; s|__PHP_VER__|${PHP_VER}|g" "${APP_DIR}/deploy/nginx-oppela.conf" > /etc/nginx/sites-available/oppela
ln -sf /etc/nginx/sites-available/oppela /etc/nginx/sites-enabled/oppela
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx

passo "Operazione pianificata (elimina i venduti dopo 7 giorni)"
echo "* * * * * www-data cd ${APP_DIR} && php artisan schedule:run >> /dev/null 2>&1" > /etc/cron.d/oppela
chmod 644 /etc/cron.d/oppela

passo "Firewall"
ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw --force enable

echo -e "\n\033[1;32m================ SITO ONLINE ================\033[0m"
echo "Indirizzo:            http://${IP_PUBBLICO}"
echo "Registrazione Paola:  http://${IP_PUBBLICO}/register"
echo "Codice invito:        ${CODICE_INVITO}   (da dare solo a Paola)"
echo "Aggiornamenti futuri: bash ${APP_DIR}/deploy/aggiorna.sh"
