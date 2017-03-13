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
        parent::__construct();

        $this->di = $di;
        $this->book = new Book($di);
    }

    public function actionList($request, $response, $args) {
        // $query = $request->getQueryParams();
        $this->book->handleActionList($this->code, $this->msg, $this->data);
        return $this->json($response);
    }

    public function actionDetail($request, $response, $args) {
        $this->book->handleActionDetail($args['id'], $this->code, $this->msg, $this->data);
        return $this->json($response);
    }

    public function actionAdd($request, $response, $args) {
        $postData = $request->getParsedBody();
        $this->book->handleActionAdd($postData, $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionUpdate($request, $response, $args) {
        $putData = $request->getParsedBody();
        $this->book->handleActionUpdate($args['id'], $putData, $this->code, $this->msg);

        return $this->json($response);
    }

    public function actionDelete($request, $response, $args) {
        $this->book->handleActionDelete($args['id'], $this->code, $this->msg);
        return $this->json($response);
    }
}
?>