<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => '213107712453040',
        'client_secret' => 'c3166c4a2ac3b71f4ae3f5ad2530eac6',
        'redirect' => 'http://localhost/Laravel-5.4/callbackFB',
    ],
    'google' => [
        'client_id' => '355763479347-321u7n7faeuuh9k7sjbm4igb6bcsjb93.apps.googleusercontent.com',
        'client_secret' => 'Prdy9ORgyNOfKiwurZf9MREi',
        'redirect' => 'http://localhost/Laravel-5.4/callbackGoogle',
    ],

];
