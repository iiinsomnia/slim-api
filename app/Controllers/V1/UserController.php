<?php
namespace App\Controllers\V1;

use App\Controllers\BaseController;
use App\Service\User;
use Psr\Container\ContainerInterface;

class UserController extends BaseController
{
    private $_di;

    // constructor receives container instance
    function __construct(ContainerInterface $di)
    {
        parent::__construct();

        $this->_di = $di;
    }

    public function actionView($request, $response, $args)
    {
        $uuid = $request->getHeader('Access-UUID');

        $user = new User($this->_di);
        $user->handleActionView($uuid[0], $this->code, $this->msg, $this->data);

        return $this->json($response);
    }
}
?>