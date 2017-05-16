<?php
namespace App\Controllers;

use App\Service\Auth;
use Psr\Container\ContainerInterface;

class AuthController extends Controller
{
    // constructor receives container instance
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    public function actionLogin($request, $response, $args)
    {
        $uuid = $request->getHeader('Access-UUID');
        $postData = $request->getParsedBody();

        $auth = new Auth($this->container);
        $auth->handleActionLogin($uuid[0], $postData, $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionLogout($request, $response, $args)
    {
        $uuid = $request->getHeader('Access-UUID');

        $auth = new Auth($this->container);
        $auth->handleActionLogout($uuid[0]);

        return $this->json($response);
    }
}
?>