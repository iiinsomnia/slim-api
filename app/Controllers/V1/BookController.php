<?php
namespace App\Controllers\V1;

use App\Controllers\BaseController;
use App\Service\Book;
use Psr\Container\ContainerInterface;

class BookController extends BaseController
{
    protected $di;
    protected $book;

    // constructor receives container instance
    function __construct(ContainerInterface $di) {
        $this->di = $di;
        $this->book = new Book($di);
    }

    public function actionList($request, $response, $args) {
        // $query = $request->getQueryParams();
        $result = $this->book->handleActionList();

        return $this->json($response, $result['code'], $result['msg'], $result['data']);
    }

    public function actionDetail($request, $response, $args) {
        $result = $this->book->handleActionDetail($args['id']);

        return $this->json($response, $result['code'], $result['msg'], $result['data']);
    }

    public function actionAdd($request, $response, $args) {
        $data = $request->getParsedBody();
        $result = $this->book->handleActionAdd($data);

        return $this->json($response, $result['code'], $result['msg'], $result['data']);
    }

    public function actionUpdate($request, $response, $args) {
        $data = $request->getParsedBody();
        $result = $this->book->handleActionUpdate($args['id'], $data);

        return $this->json($response, $result['code'], $result['msg'], $result['data']);
    }

    public function actionDelete($request, $response, $args) {
        $result = $this->book->handleActionDelete($args['id']);

        return $this->json($response, $result['code'], $result['msg'], $result['data']);
    }
}
?>