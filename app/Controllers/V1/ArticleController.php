<?php
namespace App\Controllers\V1;

use App\Controllers\Controller;
use App\Helpers\ValidateHelper;
use App\Service\V1\Article;
use Psr\Container\ContainerInterface;

class ArticleController extends Controller
{
    // constructor receives container instance
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    public function list($request, $response, $args)
    {
        // $query = $request->getQueryParams();
        $this->container->ArticleV1->handleList($this->code, $this->msg, $this->resp);

        return $this->json($response);
    }

    public function detail($request, $response, $args)
    {
        $this->container->ArticleV1->handleDetail($args['id'], $this->code, $this->msg, $this->resp);

        return $this->json($response);
    }

    public function add($request, $response, $args)
    {
        $input = $request->getParsedBody();

        $errors = ValidateHelper::validate($input, $this->container->ArticleV1->rules());

        if (!empty($errors)) {
            $this->code = -1;
            $this->msg = implode(';', $errors);

            return $this->json($response);;
        }

        $this->container->ArticleV1->handleAdd($input, $this->code, $this->msg, $this->resp);

        return $this->json($response);
    }

    public function update($request, $response, $args)
    {
        $putData = $request->getParsedBody();

        $this->container->ArticleV1->handleUpdate($args['id'], $putData, $this->code, $this->msg);

        return $this->json($response);
    }

    public function delete($request, $response, $args)
    {
        $this->container->ArticleV1->handleDelete($args['id'], $this->code, $this->msg);

        return $this->json($response);
    }
}
?>