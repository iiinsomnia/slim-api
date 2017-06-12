<?php
// Routes
$app->get('/', function ($request, $response, $args) {
    return $response->withJson([
        'code' => 0,
        'msg' => 'Welcome to slim app!',
    ], 200);
});

$app->post('/login', '\App\Controllers\AuthController:login')->add(\App\Middlewares\UUIDMiddleware::class)->setName('login');
$app->get('/logout', '\App\Controllers\AuthController:logout')->add(\App\Middlewares\UUIDMiddleware::class)->setName('logout');

$app->group('/v1', function () {
    // MySQL
    $this->get('/articles', '\App\Controllers\V1\ArticleController:list')->setName('article.index');
    $this->get('/articles/{id}', '\App\Controllers\V1\ArticleController:detail')->setName('article.view');
    $this->post('/articles', '\App\Controllers\V1\ArticleController:add')->setName('article.add');
    $this->put('/articles/{id}', '\App\Controllers\V1\ArticleController:update')->setName('article.update');
    $this->delete('/articles/{id}', '\App\Controllers\V1\ArticleController:delete')->setName('article.delete');
    // Mongo
    $this->get('/books', '\App\Controllers\V1\BookController:list')->setName('book.index');
    $this->get('/books/{id}', '\App\Controllers\V1\BookController:detail')->setName('book.view');
    $this->post('/books', '\App\Controllers\V1\BookController:add')->setName('book.add');
    $this->put('/books/{id}', '\App\Controllers\V1\BookController:update')->setName('book.update');
    $this->delete('/books/{id}', '\App\Controllers\V1\BookController:delete')->setName('book.delete');
});//->add(\App\Middlewares\SignMiddleware::class)->add(\App\Middlewares\AuthMiddleware::class);
?>