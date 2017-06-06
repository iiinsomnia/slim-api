<?php
// Routes
$app->get('/', function ($request, $response, $args) {
    return $response->withJson([
        'code' => 0,
        'msg' => 'Welcome to slim app!',
    ], 200);
});

$app->post('/login', '\App\Controllers\AuthController:actionLogin')->add(\App\Middlewares\UUIDMiddleware::class)->setName('login');
$app->get('/logout', '\App\Controllers\AuthController:actionLogout')->add(\App\Middlewares\UUIDMiddleware::class)->setName('logout');

$app->group('/v1', function () {
    $this->get('/userinfo', '\App\Controllers\V1\UserController:actionView')->setName('profile');

    $this->get('/articles', '\App\Controllers\V1\ArticleController:actionList')->setName('article.index');
    $this->get('/articles/{id}', '\App\Controllers\V1\ArticleController:actionDetail')->setName('article.view');
    $this->post('/articles', '\App\Controllers\V1\ArticleController:actionAdd')->setName('article.add');
    $this->put('/articles/{id}', '\App\Controllers\V1\ArticleController:actionUpdate')->setName('article.update');
    $this->delete('/articles/{id}', '\App\Controllers\V1\ArticleController:actionDelete')->setName('article.delete');

    $this->get('/books', '\App\Controllers\V1\BookController:actionList')->setName('book.index');
    $this->get('/books/{id}', '\App\Controllers\V1\BookController:actionDetail')->setName('book.view');
    $this->post('/books', '\App\Controllers\V1\BookController:actionAdd')->setName('book.add');
    $this->put('/books/{id}', '\App\Controllers\V1\BookController:actionUpdate')->setName('book.update');
    $this->delete('/books/{id}', '\App\Controllers\V1\BookController:actionDelete')->setName('book.delete');
})->add(\App\Middlewares\SignMiddleware::class)->add(\App\Middlewares\AuthMiddleware::class);
?>