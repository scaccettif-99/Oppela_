#!/usr/bin/env bash
# =============================================================================
#  Oppela!! - collega il dominio e attiva HTTPS (Let's Encrypt, rinnovo automatico)
#  Sul server, come root, DOPO aver puntato il DNS al server:
#
#     bash /var/www/oppela/deploy/attiva-dominio.sh
#
#  Indirizzo principale: https://www.oppelaterni.it
#  http://... e oppelaterni.it (senza www) vengono reindirizzati lì.
# =============================================================================
set -euo pipefail

DOMINIO="${DOMINIO:-oppelaterni.it}"
PRINCIPALE="www.${DOMINIO}"
EMAIL="${EMAIL:-oppela.tr@gmail.com}"
APP_DIR="/var/www/oppela"
NGINX_SITO="/etc/nginx/sites-available/oppela"
IP_SERVER="$(curl -fsS4 https://ifconfig.me)"

passo() { echo -e "\n\033[1;33m==> $*\033[0m"; }

passo "Controllo DNS: ${DOMINIO} e ${PRINCIPALE} devono puntare a ${IP_SERVER}"
apt-get install -y dnsutils >/dev/null 2>&1 || true
ok=1
for h in "${DOMINIO}" "${PRINCIPALE}"; do
    ip="$(dig +short A "$h" @1.1.1.1 | tail -1)"
    if [ "$ip" = "${IP_SERVER}" ]; then
        echo "   $h -> $ip  OK"
    else
        echo "   $h -> ${ip:-nessun indirizzo}  (atteso ${IP_SERVER})"
        ok=0
    fi
done
if [ "$ok" -ne 1 ]; then
    echo -e "\nIl DNS non punta ancora al server: niente è stato modificato."
    echo "Imposta i record A di ${DOMINIO} e ${PRINCIPALE} su ${IP_SERVER}, aspetta qualche minuto e riprova."
    exit 1
fi

passo "nginx: nome del sito"
sed -i "s|server_name .*;|server_name ${PRINCIPALE} ${DOMINIO};|" "${NGINX_SITO}"
nginx -t && systemctl reload nginx

passo "Certificato HTTPS (Let's Encrypt)"
apt-get install -y certbot python3-certbot-nginx
certbot --nginx -d "${PRINCIPALE}" -d "${DOMINIO}" --redirect \
    -m "${EMAIL}" --agree-tos -n --keep-until-expiring

passo "Indirizzo unico: tutto verso https://${PRINCIPALE}"
# blocco aggiuntivo: chi arriva su https://oppelaterni.it (senza www) va su www
cat > /etc/nginx/conf.d/oppela-senza-www.conf <<NGINX
server {
    listen 443 ssl;
    listen [::]:443 ssl;
    server_name ${DOMINIO};
    ssl_certificate /etc/letsencrypt/live/${PRINCIPALE}/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/${PRINCIPALE}/privkey.pem;
    return 301 https://${PRINCIPALE}\$request_uri;
}
NGINX
# il blocco principale risponde solo a www
sed -i "s|server_name ${PRINCIPALE} ${DOMINIO};|server_name ${PRINCIPALE};|" "${NGINX_SITO}"
# certbot ha creato il redirect http->https: lo faccio puntare sempre a www
sed -i "s|return 301 https://\$host\$request_uri;|return 301 https://${PRINCIPALE}\$request_uri;|" "${NGINX_SITO}"
nginx -t && systemctl reload nginx

passo "Configurazione del sito"
cd "${APP_DIR}"
sed -i "s|^APP_URL=.*|APP_URL=https://${PRINCIPALE}|" .env
grep -q '^SESSION_SECURE_COOKIE=' .env && sed -i 's|^SESSION_SECURE_COOKIE=.*|SESSION_SECURE_COOKIE=true|' .env \
    || echo 'SESSION_SECURE_COOKIE=true' >> .env
sudo -u www-data php artisan optimize

passo "Rinnovo automatico del certificato"
systemctl list-timers | grep -q certbot && echo "   rinnovo automatico attivo (certbot.timer)"
certbot renew --dry-run >/dev/null 2>&1 && echo "   prova di rinnovo: OK"

echo -e "\n\033[1;32m=========== DOMINIO ATTIVO ===========\033[0m"
echo "Sito:          https://${PRINCIPALE}"
echo "Registrazione: https://${PRINCIPALE}/register"
