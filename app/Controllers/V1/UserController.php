<?php
namespace App\Controllers\V1;

use App\Controllers\Controller;
use App\Service\V1\User;
use Psr\Container\ContainerInterface;

class UserController extends Controller
{
    // constructor receives container instance
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    public function actionView($request, $response, $args)
    {
        $uuid = $request->getHeader('Access-UUID');

        $user = new User($this->container);
        $user->handleActionView($uuid[0], $this->code, $this->msg, $this->data);

        return $this->json($response);
    }
}
?>