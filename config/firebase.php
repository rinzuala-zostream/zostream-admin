<?php

return [
    'default' => 'app',

    'projects' => [
        'app' => [
            'project_id' => env('FIREBASE_PROJECT_ID'),
            'credentials' => [
                'file' => env('FIREBASE_CREDENTIALS'),
            ],
            'database_url' => env('FIREBASE_DATABASE_URL'),
        ],
    ],

    'credentials' => [
        'auto_discovery' => false,
    ],
];
