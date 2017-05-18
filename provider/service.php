<?php
// DIC configuration
$container = $app->getContainer();

$container['Article'] = function ($c) {
    $service = new \App\Service\V1\Article($c);

    return $service;
};

$container['User'] = function ($c) {
    $service = new \App\Service\V1\User($c);

    return $service;
};

$container['Book'] = function ($c) {
    $service = new \App\Service\V1\Book($c);

    return $service;
};
?>