# Messa online di Oppela!! su DigitalOcean

Il repository GitHub è privato: il codice si invia dal PC al server via SSH,
in un archivio git sul server (`/srv/oppela.git`). Tutti i comandi vanno dati da
**Git Bash** nella cartella del progetto. Sostituisci `IP` con l'indirizzo della Droplet.

## 1. Creare la Droplet (una volta)

Su DigitalOcean: **Create → Droplets**

- Immagine: **Ubuntu 24.04 (LTS) x64**
- Regione: **Frankfurt (FRA1)** o Amsterdam: i server devono stare nell'UE (lo dice la privacy policy)
- Piano: Basic, Regular, **2 GB / 1 CPU** (va bene anche 1 GB: lo script aggiunge memoria di swap)
- Autenticazione: **SSH Key** → incolla il contenuto di `~/.ssh/id_ed25519.pub`
- Hostname: `oppela`

## 2. Installazione (una volta)

```bash
# archivio git sul server
ssh root@IP "apt-get update -y && apt-get install -y git && git init --bare --initial-branch=main /srv/oppela.git"

# invio del codice
git remote add server root@IP:/srv/oppela.git
git push server main

# installazione completa (10-15 minuti)
scp deploy/installa-server.sh root@IP:/root/
ssh root@IP "bash /root/installa-server.sh"
```

Alla fine lo script stampa l'indirizzo del sito e il **codice invito** per la registrazione di Paola.

## 3. Aggiornare il sito

```bash
git push origin main      # salvataggio su GitHub
git push server main      # invio al server
ssh root@IP "bash /var/www/oppela/deploy/aggiorna.sh"
```

Foto, annunci, slide e loghi caricati da Paola non vengono toccati.

## 4. Partita IVA

```bash
ssh root@IP
cd /var/www/oppela
sed -i 's/^OPPELA_PIVA=.*/OPPELA_PIVA=12345678901/' .env
sudo -u www-data php artisan optimize
```

## 5. Dominio e HTTPS (quando c'è il dominio)

1. Dal registrar del dominio: record **A** di `oppela.it` e `www.oppela.it` → `IP`.
2. Sul server:
   ```bash
   sed -i 's/server_name _;/server_name oppela.it www.oppela.it;/' /etc/nginx/sites-available/oppela
   nginx -t && systemctl reload nginx
   apt-get install -y certbot python3-certbot-nginx
   certbot --nginx -d oppela.it -d www.oppela.it --redirect -m oppela.tr@gmail.com --agree-tos -n
   cd /var/www/oppela
   sed -i 's|^APP_URL=.*|APP_URL=https://oppela.it|' .env
   echo "SESSION_SECURE_COOKIE=true" >> .env
   sudo -u www-data php artisan optimize
   ```

## Note

- **Email**: per ora le email (es. "password dimenticata") non partono (`MAIL_MAILER=log`).
  Per attivarle serve un servizio SMTP, ad esempio una password per app di Gmail.
- **Backup**: attivare i backup settimanali della Droplet dal pannello DigitalOcean (+20% del costo).
