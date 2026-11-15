@php
    $n = config('oppela.negozio');
    $durataSessione = (int) config('session.lifetime');
@endphp
<x-layout>
    <div class="container py-5 privacy-page" style="margin-top: 80px;">
        <h1 class="mb-2">Privacy e cookie policy</h1>
        <p class="text-muted">Ultimo aggiornamento: 15 novembre 2026</p>

        <p>
            Questa pagina spiega quali dati personali vengono trattati quando visiti il sito di {{ $n['nome'] }}
            e quali cookie vengono usati, ai sensi del Regolamento (UE) 2016/679 ("GDPR") e delle
            Linee guida del Garante per la protezione dei dati personali sui cookie (10 giugno 2021).
        </p>

        <h2>1. Titolare del trattamento</h2>
        <p>
            <strong>{{ $n['titolare'] }}</strong>, titolare di <strong>{{ $n['nome'] }}</strong><br>
            {{ $n['indirizzo'] }}<br>
            @if($n['piva'])
                P.IVA {{ $n['piva'] }}<br>
            @endif
            Telefono: <a href="tel:+39{{ preg_replace('/\D/', '', $n['telefono']) }}">{{ $n['telefono'] }}</a><br>
            Email: <a href="mailto:{{ $n['email'] }}">{{ $n['email'] }}</a>
        </p>

        <h2>2. Quali dati trattiamo</h2>
        <p><strong>Dati di navigazione.</strong>
            Come ogni sito, il server registra automaticamente alcune informazioni tecniche
            (indirizzo IP, tipo di browser, data e ora, pagine richieste). Servono solo a far funzionare il sito,
            a garantirne la sicurezza e a individuare eventuali problemi tecnici; non vengono usate per identificarti
            né per finalità di marketing.</p>
        <p><strong>Dati che ci invii tu.</strong>
            Se ci contatti tramite WhatsApp, telefono, email o i nostri profili social, tratteremo i dati che ci fornisci
            (ad esempio nome, numero di telefono, contenuto del messaggio) solo per risponderti e, se lo desideri,
            per gestire la richiesta di un prodotto. Il sito non contiene moduli di contatto e non raccoglie dati di pagamento:
            gli acquisti si concordano direttamente in negozio o tramite WhatsApp.</p>
        <p><strong>Area riservata.</strong>
            L'accesso con email e password è riservato al personale del negozio per gestire i contenuti del sito.
            Per questi account vengono conservati nome, email e password (salvata in forma cifrata).</p>

        <h2>3. Finalità e basi giuridiche</h2>
        <ul>
            <li>Funzionamento e sicurezza del sito: legittimo interesse del titolare (art. 6, par. 1, lett. f GDPR).</li>
            <li>Risposta alle tue richieste di informazioni sui prodotti: esecuzione di misure precontrattuali
                adottate su tua richiesta (art. 6, par. 1, lett. b GDPR).</li>
            <li>Gestione dell'area riservata: esecuzione del rapporto con il personale autorizzato (art. 6, par. 1, lett. b GDPR).</li>
        </ul>

        <h2>4. Cookie</h2>
        <p>
            Il sito usa <strong>solo cookie tecnici</strong>, necessari al suo funzionamento.
            Non usiamo cookie di profilazione, di marketing o di statistica, e non installiamo cookie di terze parti.
            Per questo, come previsto dalla normativa, non è necessario chiedere il tuo consenso e non è presente un banner.
        </p>
        <div class="table-responsive">
            <table class="table table-bordered small">
                <thead>
                    <tr><th>Nome</th><th>Tipo</th><th>Finalità</th><th>Durata</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>{{ config('session.cookie') }}</code></td>
                        <td>Tecnico, di sessione</td>
                        <td>Mantiene la sessione di navigazione e l'accesso all'area riservata</td>
                        <td>{{ $durataSessione }} minuti di inattività</td>
                    </tr>
                    <tr>
                        <td><code>XSRF-TOKEN</code></td>
                        <td>Tecnico, di sicurezza</td>
                        <td>Protegge i moduli del sito da invii fraudolenti (attacchi CSRF)</td>
                        <td>{{ $durataSessione }} minuti</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p>
            Puoi cancellare o bloccare i cookie dalle impostazioni del tuo browser; bloccando i cookie tecnici
            alcune funzioni del sito (come l'accesso all'area riservata) potrebbero non funzionare.
        </p>

        <h2>5. Servizi di terze parti e link esterni</h2>
        <ul>
            <li><strong>Mappa (OpenStreetMap).</strong> La mappa del negozio è fornita da OpenStreetMap: per mostrarla,
                il tuo browser scarica le immagini della mappa dai server della OpenStreetMap Foundation, che riceve
                il tuo indirizzo IP. Il servizio non installa cookie.
                <a href="https://osmfoundation.org/wiki/Privacy_Policy" target="_blank" rel="noopener">Privacy policy di OpenStreetMap</a>.</li>
            <li><strong>Link esterni.</strong> I pulsanti verso WhatsApp, Instagram, Facebook, TikTok e Google Maps sono
                semplici collegamenti: nessun dato viene inviato a questi servizi finché non li clicchi.
                Una volta aperti, si applicano le rispettive privacy policy.</li>
            <li><strong>Hosting.</strong> Il sito è ospitato da un fornitore di servizi cloud (DigitalOcean, LLC), che tratta
                i dati di navigazione per nostro conto come responsabile del trattamento, su server situati nell'Unione Europea.</li>
        </ul>

        <h2>6. Conservazione dei dati</h2>
        <p>
            I dati di navigazione sono conservati per il tempo strettamente necessario alla sicurezza del sito e poi cancellati.
            I messaggi che ci invii sono conservati per il tempo necessario a gestire la tua richiesta.
            Gli account dell'area riservata restano attivi finché il personale collabora con il negozio.
        </p>

        <h2>7. Comunicazione dei dati</h2>
        <p>
            I tuoi dati non vengono venduti né ceduti a terzi. Possono essere trattati solo dal titolare,
            dal fornitore di hosting e, se richiesto dalla legge, dalle autorità competenti.
            Non effettuiamo decisioni automatizzate né profilazione.
        </p>

        <h2>8. I tuoi diritti</h2>
        <p>
            In ogni momento puoi chiedere l'accesso ai tuoi dati, la loro rettifica o cancellazione, la limitazione
            del trattamento, la portabilità o opporti al trattamento (artt. 15-22 GDPR), scrivendo a
            <a href="mailto:{{ $n['email'] }}">{{ $n['email'] }}</a>.
            Hai anche il diritto di proporre reclamo al
            <a href="https://www.garanteprivacy.it" target="_blank" rel="noopener">Garante per la protezione dei dati personali</a>.
        </p>

        <h2>9. Modifiche</h2>
        <p>
            Questa informativa può essere aggiornata, ad esempio se cambiano i servizi usati dal sito.
            La data dell'ultimo aggiornamento è indicata in cima alla pagina.
        </p>
    </div>
</x-layout>
