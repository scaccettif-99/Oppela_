# Messa online di Oppela!! su DigitalOcean

Il server scarica il codice dal repository pubblico su GitHub
(`scaccettif-99/Oppela_`). I comandi vanno dati da **Git Bash** nella cartella
del progetto. Sostituisci `IP` con l'indirizzo della Droplet.

## 1. Creare la Droplet (una volta)

Su DigitalOcean: **Create → Droplets**

- Immagine: **Ubuntu 24.04 (LTS) x64**
- Regione: **Frankfurt (FRA1)** o Amsterdam: i server devono stare nell'UE (lo dice la privacy policy)
- Piano: Basic, Regular, **2 GB / 1 CPU** (va bene anche 1 GB: lo script aggiunge memoria di swap)
- Autenticazione: **SSH Key** → incolla il contenuto di `~/.ssh/id_ed25519.pub`
- Hostname: `oppela`

## 2. Installazione (una volta)

```bash
ssh root@IP "curl -fsSLo installa.sh https://raw.githubusercontent.com/scaccettif-99/Oppela_/main/deploy/installa-server.sh && bash installa.sh"
```

Ci vogliono 10-15 minuti. Alla fine lo script stampa l'indirizzo del sito
e il **codice invito** per la registrazione di Paola.

## 3. Aggiornare il sito

```bash
git push origin main
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

## 5. Dominio e HTTPS

1. Dal pannello del registrar: due record **A**, `oppelaterni.it` e `www.oppelaterni.it`, verso `IP`
   (cancellando eventuali record A/CNAME di "parcheggio" creati dal registrar).
2. Dopo qualche minuto, sul server:
   ```bash
   ssh root@IP "bash /var/www/oppela/deploy/attiva-dominio.sh"
   ```
   Lo script controlla prima il DNS (se non punta ancora al server si ferma senza toccare nulla),
   poi attiva il certificato HTTPS con rinnovo automatico e porta tutto su `https://www.oppelaterni.it`.

## Note

- **Email**: per ora le email (es. "password dimenticata") non partono (`MAIL_MAILER=log`).
  Per attivarle serve un servizio SMTP, ad esempio una password per app di Gmail.
- **Backup**: attivare i backup settimanali della Droplet dal pannello DigitalOcean (+20% del costo).
