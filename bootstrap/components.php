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
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

if (!env('APP_DEBUG', true)) {
    // ErrorHandler
    $container['errorHandler'] = function ($c) {
        return function ($request, $response, $error) use ($c) {
            $c['logger']->error(null, [
                    'message' => $error->getMessage(),
                    'file'    => $error->getFile(),
                    'line'    => $error->getLine(),
                ]);

            return $response->withJson([
                'code' => -1,
                'msg' => 'server internal error',
            ], 200);
        };
    };

    // PHPErrorHandler
    $container['phpErrorHandler'] = function ($c) {
        return function ($request, $response, $error) use ($c) {
            $c['logger']->error(null, [
                    'message' => $error->getMessage(),
                    'file'    => $error->getFile(),
                    'line'    => $error->getLine(),
                ]);

            return $response->withJson([
                'code' => -1,
                'msg' => 'server internal error',
            ], 200);
        };
    };
}
?>