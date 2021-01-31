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
            'success' => true,
            'message' => 'Message goes here',
            'errors' => new \stdClass(),
            'data' => new \stdClass(),
        ],
        'failure' => [
            'success' => false,
            'message' => 'Message goes here',
            'errors' => new \stdClass(),
            'data' => new \stdClass(),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware to be applied /laradocs
    |
    */

    'middleware' => 'auth.basic',
    /*
    |--------------------------------------------------------------------------
    | Request Headers
    |--------------------------------------------------------------------------
    |
    | Headers to be included in every request
    |
    */

    'default_headers' => [
        'auth' => [
            'name' => 'Authorization',
            'type' => 'Bearer {token}',
            'required' => 'REQUIRED',
            'description' => 'Authorization Token',
        ],
        'accept' => [
            'name' => 'Accept',
            'type' => 'application/json',
            'required' => 'REQUIRED',
            'description' => 'Must accept JSON',
        ],
    ],
];
