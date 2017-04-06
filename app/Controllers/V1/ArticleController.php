<?php
namespace App\Controllers\V1;

use App\Controllers\BaseController;
use App\Service\Article;
use Psr\Container\ContainerInterface;

class ArticleController extends BaseController
{
    private $_di;

    // constructor receives container instance
    function __construct(ContainerInterface $di)
    {
        parent::__construct();

        $this->_di = $di;
    }

    public function actionList($request, $response, $args)
    {
        // $query = $request->getQueryParams();
        $article = new Article($this->_di);
        $article->handleActionList($this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionDetail($request, $response, $args)
    {
        $article = new Article($this->_di);
        $article->handleActionDetail($args['id'], $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionAdd($request, $response, $args)
    {
        $postData = $request->getParsedBody();

        $article = new Article($this->_di);
        $article->handleActionAdd($postData, $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionUpdate($request, $response, $args)
    {
        $putData = $request->getParsedBody();

        $article = new Article($this->_di);
        $article->handleActionUpdate($args['id'], $putData, $this->code, $this->msg);

        return $this->json($response);
    }

    public function actionDelete($request, $response, $args)
    {
        $article = new Article($this->_di);
        $article->handleActionDelete($args['id'], $this->code, $this->msg);

        return $this->json($response);
    }
}
?>