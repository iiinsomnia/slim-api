<?php
namespace App\Controllers\V1;

use App\Controllers\Controller;
use App\Service\V1\Student;
use Psr\Container\ContainerInterface;

class StudentController extends Controller
{
    // constructor receives container instance
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    public function list($request, $response, $args)
    {
        // $query = $request->getQueryParams();
        $this->container->StudentV1->handleList($this->code, $this->msg, $this->resp);

        return $this->json($response);
    }

    public function detail($request, $response, $args)
    {
        $this->container->StudentV1->handleDetail($args['id'], $this->code, $this->msg, $this->resp);

        return $this->json($response);
    }

    public function add($request, $response, $args)
    {
        $input = $request->getParsedBody();

        $this->container->StudentV1->handleAdd($input, $this->code, $this->msg, $this->resp);

        return $this->json($response);
    }

    public function update($request, $response, $args)
    {
        $putData = $request->getParsedBody();

        $this->container->StudentV1->handleUpdate($args['id'], $putData, $this->code, $this->msg);

        return $this->json($response);
    }

    public function delete($request, $response, $args)
    {
        $this->container->StudentV1->handleDelete($args['id'], $this->code, $this->msg);

        return $this->json($response);
    }
}
?>