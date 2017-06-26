<?php
// DIC configuration
$container = $app->getContainer();

$container['UserDao'] = function($c) {
    $dao = new App\Dao\MySQL\UserDao($c);

    return $dao;
};

$container['BookDao'] = function($c) {
    $dao = new App\Dao\MySQL\BookDao($c);

    return $dao;
};

$container['StudentDao'] = function($c) {
    $dao = new App\Dao\Mongo\StudentDao($c);

    return $dao;
};
?>