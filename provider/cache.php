<?php
// DIC configuration
$container = $app->getContainer();

$container['AuthCache'] = function ($c) {
    $dao = new \App\Cache\AuthCache($c);

    return $dao;
};

$container['ArticleCache'] = function ($c) {
    $dao = new \App\Cache\ArticleCache($c);

    return $dao;
};
?>