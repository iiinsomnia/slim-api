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
        $this->container->BookV1->handleActionList($this->code, $this->msg, $this->resp);

        return $this->json($response);
    }

    public function actionDetail($request, $response, $args)
    {
        $this->container->BookV1->handleActionDetail($args['id'], $this->code, $this->msg, $this->resp);

        return $this->json($response);
    }

    public function actionAdd($request, $response, $args)
    {
        $input = $request->getParsedBody();

        $this->container->BookV1->handleActionAdd($input, $this->code, $this->msg, $this->resp);

        return $this->json($response);
    }

    public function actionUpdate($request, $response, $args)
    {
        $putData = $request->getParsedBody();

        $this->container->BookV1->handleActionUpdate($args['id'], $putData, $this->code, $this->msg);

        return $this->json($response);
    }

    public function actionDelete($request, $response, $args)
    {
        $this->container->BookV1->handleActionDelete($args['id'], $this->code, $this->msg);

        return $this->json($response);
    }
}
?>