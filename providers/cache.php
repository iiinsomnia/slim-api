<?php
// DIC configuration
$container = $app->getContainer();

$container['AuthCache'] = function($c) {
    $cache = new \App\Cache\AuthCache($c);

    return $cache;
};

$container['BookCache'] = function($c) {
    $cache = new \App\Cache\BookCache($c);

    return $cache;
};
?>