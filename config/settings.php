<?php
return [
    'settings' => [
        'debug' => env('APP_DEBUG', true),
        'displayErrorDetails' => env('APP_DEBUG', true), // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // NotORM settings
        'db' => [
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'test'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
        ],

        // MongoDB settings
        'mongo' => [
            'host' => env('MONGO_HOST', '127.0.0.1'),
            'port' => env('MONGO_PORT', '27017'),
            'username' => env('MONGO_USERNAME', null),
            'password' => env('MONGO_PASSWORD', null),
        ],

        // Predis settings
        'redis' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', 6379),
            'password' => env('REDIS_PASSWORD', null),
            'database' => env('REDIS_DATABASE', 0),
            'prefix' => env('REDIS_PREFIX', ''),
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/'.date('Y-m-d').'.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
