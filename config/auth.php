<?php

return [


    'defaults' => [
    'guard' => 'web',  // Ensure this is set to 'web'
    ],



    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',  // Using the default provider for 'users' table
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,  // Default User model
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',  // Password reset for the 'users' provider
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,  // 3 hours of timeout

];
