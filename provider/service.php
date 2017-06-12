<?php
// DIC configuration
$container = $app->getContainer();

$container['Auth'] = function ($c) {
    $uuid = $c->request->getHeader('Access-UUID');
    $service = new \App\Service\Auth($c, $uuid[0]);

    return $service;
};

$container['UserV1'] = function ($c) {
    $uuid = $c->request->getHeader('Access-UUID');
    $service = new \App\Service\V1\User($c, $uuid[0]);

    return $service;
};

$container['ArticleV1'] = function ($c) {
    $uuid = $c->request->getHeader('Access-UUID');
    $service = new \App\Service\V1\Article($c, $uuid[0]);

    return $service;
};

$container['BookV1'] = function ($c) {
    $uuid = $c->request->getHeader('Access-UUID');
    $service = new \App\Service\V1\Book($c, $uuid[0]);

    return $service;
};
?>