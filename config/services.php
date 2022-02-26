<?php

declare(strict_types = 1);

return [
    'pwe' => [
        'base_uri' => env('PWE_SERVICE_BASE_URI'),
        'secret' => env('PWE_SERVICE_SECRET')
    ],
    'pew_statistics' => [
        'base_uri' => env('PWE_STATISTICS_SERVICE_BASE_URI'),
        'secret' => env('PWE_STATISTICS_SECRET'),
    ]
];
