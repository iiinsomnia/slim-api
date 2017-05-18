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
        $this->container->Book->handleActionList($this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionDetail($request, $response, $args)
    {
        $this->container->Book->handleActionDetail($args['id'], $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionAdd($request, $response, $args)
    {
        $postData = $request->getParsedBody();

        $this->container->Book->handleActionAdd($postData, $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionUpdate($request, $response, $args)
    {
        $putData = $request->getParsedBody();

        $this->container->Book->handleActionUpdate($args['id'], $putData, $this->code, $this->msg);

        return $this->json($response);
    }

    public function actionDelete($request, $response, $args)
    {
        $this->container->Book->handleActionDelete($args['id'], $this->code, $this->msg);

        return $this->json($response);
    }
}
?>