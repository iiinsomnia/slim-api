<?php
namespace App\Controllers\V1;

use App\Controllers\Controller;
use App\Service\V1\Book;
use Psr\Container\ContainerInterface;

class BookController extends Controller
{
    // constructor receives container instance
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    public function actionList($request, $response, $args)
    {
        // $query = $request->getQueryParams();
        $book = new Book($this->container);
        $book->handleActionList($this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionDetail($request, $response, $args)
    {
        $book = new Book($this->container);
        $book->handleActionDetail($args['id'], $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionAdd($request, $response, $args)
    {
        $postData = $request->getParsedBody();

        $book = new Book($this->container);
        $book->handleActionAdd($postData, $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionUpdate($request, $response, $args)
    {
        $putData = $request->getParsedBody();

        $book = new Book($this->container);
        $book->handleActionUpdate($args['id'], $putData, $this->code, $this->msg);

        return $this->json($response);
    }

    public function actionDelete($request, $response, $args)
    {
        $book = new Book($this->container);
        $book->handleActionDelete($args['id'], $this->code, $this->msg);

        return $this->json($response);
    }
}
?>