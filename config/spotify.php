<?php

return [
    'client_id' => env('SPOTIFY_CLIENT_ID'),
    'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
    'redirect_uri' => env('SPOTIFY_REDIRECT_URI', env('APP_URL').'/callback'),
    'scopes' => [
        'user-read-currently-playing'
    ],
];