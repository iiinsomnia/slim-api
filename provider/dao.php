<?php
// DIC configuration
$container = $app->getContainer();

$container['ArticleDao'] = function ($c) {
    $dao = new App\Dao\MySQL\ArticleDao($c);

    return $dao;
};

$container['UserDao'] = function ($c) {
    $dao = new App\Dao\MySQL\UserDao($c);

    return $dao;
};

$container['BookDao'] = function ($c) {
    $dao = new App\Dao\Mongo\BookDao($c);

    return $dao;
};
?>