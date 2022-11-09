<?php

return [
    'navigation' => [
        'Account',
        'Sistema',
        'Configurazioni',
    ],

    'profile' => [
        'resource' => [
            'label' => 'Profilo',
            'labels' => 'Profilo',
            'title' => 'Profilo',
            'slug' => 'account/profilo',
            'nav' => [
                'group' => 'Account',
                'label' => 'Profilo',
            ]
        ],
        'field' => [
            'name' => 'Nome',
            'email' => 'Email',
            'current-password' => 'Password corrente',
            'new-password' => 'Nuova Password',
            'confirm-password' => 'Conferma Password',
        ],
        'button' => [
            'save' => 'Salva',
            'cancel' => 'Annulla',
        ],
        'notification' => [
            'success' => 'Il tuo profilo è stato aggiornato.'
        ],
    ],

    'roles' => [
        'resource' => [
            'label' => 'Ruolo',
            'labels' => 'Ruoli',
            'title' => 'Ruoli',
            'slug' => 'account/ruoli',
            'nav' => [
                'group' => 'Account',
                'label' => 'Ruoli',
            ]
        ],
        'field' => [],
        'button' => [],
        'notification' => [],
    ],

    'users' => [
        'resource' => [
            'label' => 'Utente',
            'labels' => 'Utenti',
            'title' => 'Utenti',
            'slug' => 'account/utenti',
            'nav' => [
                'group' => 'Account',
                'label' => 'Utenti',
            ]
        ],
        'field' => [
            'name' => 'Nome',
            'email' => 'Email',
            'password' => 'Password',
            'confirm-password' => 'Conferma Password',
            'roles' => 'Ruoli',
            'created-at' => 'Creato il',
            'updated-at' => 'Aggiornato il',
        ],
        'button' => [],
        'notification' => [
            'password-helper' => 'lascialo vuoto se non vuoi cambiare.'
        ],
    ],

    'log-activities' => [
        'resource' => [
            'label' => 'Log Attività',
            'labels' => 'Log Attività',
            'title' => 'Log Attività',
            'slug' => 'system/log-attività',
            'nav' => [
                'group' => 'Sistema',
                'label' => 'Log Attività',
            ]
        ],
        'field' => [
            'username' => 'Nome utente',
            'action' => 'Azione',
            'information' => 'Informazione',
            'time' => 'Tempo',
        ],
        'filter' => [
            'action' => 'Azione',
            'date-start' => 'Data da',
            'date-end' => 'Data fino a',
        ],
        'button' => [],
        'notification' => [],
    ],

    'setting' => [
        'manage-site' => [
            'resource' => [
                'label' => 'Gestisci Sito',
                'labels' => 'Gestisci Sito',
                'title' => 'Gestisci Sito',
                'slug' => 'configurazione/sito',
                'nav' => [
                    'group' => 'Configurazioni',
                    'label' => 'Sito',
                ]
            ],
            'field' => [
                'general' => 'Generale',
                'name' => 'Nome Applicazione',
                'slogan' => 'Slogan',
                'image' => 'Immagini',
                'logo' => 'Logo Applicazione',
                'icon' => 'Icona Applicazione',
            ],
            'filter' => [],
            'button' => [
                'save' => 'Salva',
                'cancel' => 'Annulla',
            ],
            'notification' => [],
        ],
    ],
];
