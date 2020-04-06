<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Endpoints
    |--------------------------------------------------------------------------
    |
    | Define your sandbox and live environment enpoints here
    |
    */

    'endpoints' => [
        'live' => env('LARADOCS_LIVE_ENDPOINT', 'https://live.com'),
        'sandbox' => env('LARADOCS_SANDBOX_ENDPOINT', 'https://sandbox.com'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Response Format
    |--------------------------------------------------------------------------
    |
    | Success and Failure response formats
    |
    */

    'response' => [
        'success' => [
            'code' => 1,
            'message' => 'Message',
            'errors' => [],
            'data' => [],
        ],
        'failure' => [
            'code' => 0,
            'message' => 'Message',
            'errors' => [],
            'data' => [],
        ],
    ],
];
