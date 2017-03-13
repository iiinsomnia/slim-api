<?php
namespace App\Controllers\V1;

use App\Controllers\BaseController;
use App\Service\User;
use Psr\Container\ContainerInterface;

class UserController extends BaseController
{
    protected $di;
    protected $user;

    // constructor receives container instance
    function __construct(ContainerInterface $di) {
        parent::__construct();

        $this->di = $di;
        $this->user = new User($di);
    }

    public function actionList($request, $response, $args) {
        // $query = $request->getQueryParams();
        $this->user->handleActionList($this->code, $this->msg, $this->data);
        return $this->json($response);
    }

    public function actionDetail($request, $response, $args) {
        $this->user->handleActionDetail($args['id'], $this->code, $this->msg, $this->data);
        return $this->json($response);
    }

    public function actionAdd($request, $response, $args) {
        $postData = $request->getParsedBody();
        $this->user->handleActionAdd($postData, $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionUpdate($request, $response, $args) {
        $putData = $request->getParsedBody();
        $this->user->handleActionUpdate($args['id'], $putData, $this->code, $this->msg);

        return $this->json($response);
    }

    public function actionDelete($request, $response, $args) {
        $this->user->handleActionDelete($args['id'], $this->code, $this->msg);
        return $this->json($response);
    }
}
?>