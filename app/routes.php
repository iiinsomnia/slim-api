<?php
// Routes
$app->get('/', function ($request, $response, $args) {
    return $response->withJson([
        'code' => 0,
        'msg' => 'Welcome to slim app!',
    ], 200);
});

$app->add(\App\Middlewares\AuthMiddleware::class)->group('/v1', function () {
    $this->get('/users', '\App\Controllers\V1\UserController:actionList');
    $this->get('/users/{id}', '\App\Controllers\V1\UserController:actionDetail');
    $this->post('/users', '\App\Controllers\V1\UserController:actionAdd');
    $this->put('/users/{id}', '\App\Controllers\V1\UserController:actionUpdate');
    $this->delete('/users/{id}', '\App\Controllers\V1\UserController:actionDelete');

    $this->get('/books', '\App\Controllers\V1\BookController:actionList');
    $this->get('/books/{id}', '\App\Controllers\V1\BookController:actionDetail');
    $this->post('/books', '\App\Controllers\V1\BookController:actionAdd');
    $this->put('/books/{id}', '\App\Controllers\V1\BookController:actionUpdate');
    $this->delete('/books/{id}', '\App\Controllers\V1\BookController:actionDelete');
});
