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
        $this->di = $di;
        $this->user = new User($di);
    }

    public function actionList($request, $response, $args) {
        // $query = $request->getQueryParams();
        $result = $this->user->handleActionList();

        return $this->json($response, $result['code'], $result['msg'], $result['data']);
    }

    public function actionDetail($request, $response, $args) {
        $result = $this->user->handleActionDetail($args['id']);

        return $this->json($response, $result['code'], $result['msg'], $result['data']);
    }

    public function actionAdd($request, $response, $args) {
        $data = $request->getParsedBody();
        $result = $this->user->handleActionAdd($data);

        return $this->json($response, $result['code'], $result['msg'], $result['data']);
    }

    public function actionUpdate($request, $response, $args) {
        $data = $request->getParsedBody();
        $result = $this->user->handleActionUpdate($args['id'], $data);

        return $this->json($response, $result['code'], $result['msg'], $result['data']);
    }

    public function actionDelete($request, $response, $args) {
        $result = $this->user->handleActionDelete($args['id']);

        return $this->json($response, $result['code'], $result['msg'], $result['data']);
    }
}
?>