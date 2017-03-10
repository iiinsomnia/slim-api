<?php
// DIC configuration
$container = $app->getContainer();

// GreetCommand
$container['greet'] = function ($c) {
    $cmd = new \Commands\GreetCommand($c);

    return $cmd;
};
?>