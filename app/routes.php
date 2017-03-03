<?php
// Routes
$app->get('/', function ($request, $response, $args) {
    return $response->withJson([
        'code' => 0,
        'msg' => 'Welcome to slim app!',
    ], 200);
});

$app->add(new App\Middlewares\AuthMiddleware)->group('/api', function () {
    $this->group('/v1', function () {
        $this->group('/user', function () {
            $this->get('/detail', '\App\Controllers\V1\UserController:detail');
            $this->get('/list', '\App\Controllers\V1\UserController:list');
        });
    });
});
