<?php
// Routes
$app->get('/', function($request, $response, $args) {
    return $response->withJson([
        'code' => 0,
        'msg' => 'Welcome to slim app!',
    ], 200);
});

$app->post('/login', '\App\Controllers\AuthController:login')->add(\App\Middlewares\UUIDMiddleware::class)->setName('login');
$app->get('/logout', '\App\Controllers\AuthController:logout')->add(\App\Middlewares\UUIDMiddleware::class)->setName('logout');

$app->group('/v1', function() {
    // MySQL
    $this->get('/books', '\App\Controllers\V1\BookController:list')->setName('book.index');
    $this->get('/books/{id}', '\App\Controllers\V1\BookController:detail')->setName('book.view');
    $this->post('/books', '\App\Controllers\V1\BookController:add')->setName('book.add');
    $this->put('/books/{id}', '\App\Controllers\V1\BookController:update')->setName('book.update');
    $this->delete('/books/{id}', '\App\Controllers\V1\BookController:delete')->setName('book.delete');
    // Mongo
    $this->get('/students', '\App\Controllers\V1\StudentController:list')->setName('student.index');
    $this->get('/students/{id}', '\App\Controllers\V1\StudentController:detail')->setName('student.view');
    $this->post('/students', '\App\Controllers\V1\StudentController:add')->setName('student.add');
    $this->put('/students/{id}', '\App\Controllers\V1\StudentController:update')->setName('student.update');
    $this->delete('/students/{id}', '\App\Controllers\V1\StudentController:delete')->setName('student.delete');
})->add(\App\Middlewares\SignMiddleware::class)->add(\App\Middlewares\AuthMiddleware::class);
?>