<?php
// DIC configuration
$container = $app->getContainer();

// Illuminate/database
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];

    $capsule = new \Illuminate\Database\Capsule\Manager;

    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => $settings['host'],
        'database'  => $settings['database'],
        'username'  => $settings['username'],
        'password'  => $settings['password'],
        'charset'   => $settings['charset'],
        'collation' => $settings['collation'],
        'prefix'    => $settings['prefix'],
    ]);

    $capsule->setAsGlobal();

    return $capsule;
};

// MongoDB
$container['mongo'] = function ($c) {
    $settings = $c->get('settings')['mongo'];

    $dsn = sprintf('mongodb://%s:%s', $settings['host'], $settings['port']);

    if (!empty($settings['username'])) {
        $dsn = sprintf('mongodb://%s:%s@%s:%s', $settings['username'], $settings['password'], $settings['host'], $settings['port']);
    }

    $client = new \MongoDB\Client($dsn);

    return $client;
};

// Predis
$container['redis'] = function ($c) {
    $settings = $c->get('settings')['redis'];

    $client = new \Predis\Client([
        'scheme'   => 'tcp',
        'host'     => $settings['host'],
        'port'     => $settings['port'],
        'password' => $settings['password'],
        'database' => $settings['database'],
    ], ['prefix' => $settings['prefix']]);

    return $client;
};

// Monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];

    $logger = new Monolog\Logger($settings['name']);
    $file_handler = new Monolog\Handler\StreamHandler($settings['path'], $settings['level']);
    $logger->pushHandler($file_handler);

    return $logger;
};
?>