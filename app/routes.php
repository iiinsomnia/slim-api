<?php
// Routes
$app->get('/', function ($request, $response, $args) {
    return $response->withJson([
        'code' => 0,
        'msg' => 'Welcome to slim app!',
    ], 200);
});

$app->post('/login', '\App\Controllers\AuthController:actionLogin')->add(\App\Middlewares\UUIDMiddleware::class);
$app->get('/logout', '\App\Controllers\AuthController:actionLogout')->add(\App\Middlewares\UUIDMiddleware::class);

$app->group('/v1', function () {
    $this->get('/userinfo', '\App\Controllers\V1\UserController:actionView');

    $this->get('/articles', '\App\Controllers\V1\ArticleController:actionList');
    $this->get('/articles/{id}', '\App\Controllers\V1\ArticleController:actionDetail');
    $this->post('/articles', '\App\Controllers\V1\ArticleController:actionAdd');
    $this->put('/articles/{id}', '\App\Controllers\V1\ArticleController:actionUpdate');
    $this->delete('/articles/{id}', '\App\Controllers\V1\ArticleController:actionDelete');

    $this->get('/books', '\App\Controllers\V1\BookController:actionList');
    $this->get('/books/{id}', '\App\Controllers\V1\BookController:actionDetail');
    $this->post('/books', '\App\Controllers\V1\BookController:actionAdd');
    $this->put('/books/{id}', '\App\Controllers\V1\BookController:actionUpdate');
    $this->delete('/books/{id}', '\App\Controllers\V1\BookController:actionDelete');
});//->add(\App\Middlewares\AuthMiddleware::class);
?>