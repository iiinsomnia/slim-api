<?php
// DIC configuration
$container = $app->getContainer();

$container['Auth'] = function ($c) {
    $service = new \App\Service\Auth($c);

    return $service;
};

$container['UserV1'] = function ($c) {
    $service = new \App\Service\V1\User($c);

    return $service;
};

$container['ArticleV1'] = function ($c) {
    $service = new \App\Service\V1\Article($c);

    return $service;
};

$container['BookV1'] = function ($c) {
    $service = new \App\Service\V1\Book($c);

    return $service;
};
?>