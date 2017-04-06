<?php
namespace App\Controllers;

use App\Service\Auth;
use Psr\Container\ContainerInterface;

class AuthController extends BaseController
{
    private $_di;

    // constructor receives container instance
    function __construct(ContainerInterface $di)
    {
        parent::__construct();

        $this->_di = $di;
    }

    public function actionLogin($request, $response, $args)
    {
        $uuid = $request->getHeader('Access-UUID');
        $postData = $request->getParsedBody();

        $auth = new Auth($this->_di);
        $auth->handleActionLogin($uuid[0], $postData, $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionLogout($request, $response, $args)
    {
        $uuid = $request->getHeader('Access-UUID');

        $auth = new Auth($this->_di);
        $auth->handleActionLogout($uuid[0]);

        return $this->json($response);
    }
}
?>