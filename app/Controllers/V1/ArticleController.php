<?php
namespace App\Controllers\V1;

use App\Controllers\Controller;
use App\Service\V1\Article;
use Psr\Container\ContainerInterface;

class ArticleController extends Controller
{
    // constructor receives container instance
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    public function actionList($request, $response, $args)
    {
        // $query = $request->getQueryParams();
        $article = new Article($this->container);
        $article->handleActionList($this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionDetail($request, $response, $args)
    {
        $article = new Article($this->container);
        $article->handleActionDetail($args['id'], $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionAdd($request, $response, $args)
    {
        $postData = $request->getParsedBody();

        $article = new Article($this->container);
        $article->handleActionAdd($postData, $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionUpdate($request, $response, $args)
    {
        $putData = $request->getParsedBody();

        $article = new Article($this->container);
        $article->handleActionUpdate($args['id'], $putData, $this->code, $this->msg);

        return $this->json($response);
    }

    public function actionDelete($request, $response, $args)
    {
        $article = new Article($this->container);
        $article->handleActionDelete($args['id'], $this->code, $this->msg);

        return $this->json($response);
    }
}
?>