#!/usr/bin/env bash
# =============================================================================
#  Oppela!! - aggiorna il sito online con l'ultima versione su GitHub.
#  Sul server, come root:   bash /var/www/oppela/deploy/aggiorna.sh
#  Foto caricate da Paola, annunci, slide e loghi NON vengono toccati.
# =============================================================================
set -euo pipefail
APP_DIR="/var/www/oppela"
PHP_VER="8.4"
cd "${APP_DIR}"

echo "==> Modalita' manutenzione"
sudo -u www-data php artisan down --retry=30 || true
trap 'sudo -u www-data php artisan up || true' EXIT   # il sito torna su anche se qualcosa va storto

echo "==> Nuova versione"
git config --global --add safe.directory "${APP_DIR}" 2>/dev/null || true
git pull --ff-only

echo "==> Dipendenze e stili"
export COMPOSER_ALLOW_SUPERUSER=1
composer install --no-dev --optimize-autoloader --no-interaction
# il package-lock.json generato su Windows può non elencare i moduli solo-Linux (difetto noto di npm):
# in quel caso installo normalmente e poi ripristino il file, così "git pull" resta pulito
npm ci --no-audit --no-fund || { npm install --no-audit --no-fund && git checkout -- package-lock.json; }
npm run build
rm -f public/hot

echo "==> Database"
php artisan migrate --force

echo "==> Permessi e cache"
chown -R www-data:www-data "${APP_DIR}"
sudo -u www-data php artisan optimize
systemctl reload php${PHP_VER}-fpm

echo "==> Fatto: sito aggiornato."
