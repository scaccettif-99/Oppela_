<?php

return [
    /*
     * Codice invito per la registrazione. Se impostato (CODICE_REGISTRAZIONE nel file .env),
     * per registrarsi bisogna conoscerlo: così nessun estraneo può creare un account
     * con i permessi di gestione prima di Paola. Vuoto = registrazione senza codice.
     */
    'codice_registrazione' => env('CODICE_REGISTRAZIONE'),

    /*
     * Dati del negozio: footer, pagina privacy, mappa.
     * La partita IVA va indicata per legge sul sito: impostala con OPPELA_PIVA nel file .env
     * (finché è vuota non viene mostrata).
     */
    'negozio' => [
        'nome'      => 'Oppela!!',
        'titolare'  => 'Paola Tinarelli',
        'indirizzo' => 'Viale Papa Zaccaria 1/A, 05100 Terni (TR)',
        'telefono'  => '338 152 0444',
        'email'     => 'oppela.tr@gmail.com',
        'piva'      => env('OPPELA_PIVA'),
    ],
];
