<?php
// DIC configuration
$container = $app->getContainer();

// NotORM
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];

    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s', $settings['host'], $settings['port'], $settings['database']);

    $pdo = new PDO($dsn, $settings['username'], $settings['password']);
    $pdo->exec(sprintf('set names %s', $settings['charset']));

    $db = new NotORM($pdo);
    $db->debug = $c->get('settings')['debug'];

    return $db;
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
    // $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};
?>