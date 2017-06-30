<?php
namespace App\Controllers;

use App\Helpers\ValidateHelper;
use App\Service\Auth;
use Psr\Container\ContainerInterface;

class AuthController extends Controller
{
    // constructor receives container instance
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    public function login($request, $response, $args)
    {
        $input = $request->getParsedBody();

        $errors = ValidateHelper::validate($input, $this->container->Auth->loginRules());

        if (!empty($errors)) {
            $this->code = -1;
            $this->msg = implode(';', $errors);

            return $this->json($response);;
        }

        $this->container->Auth->handleLogin($input, $this->code, $this->msg, $this->resp);

        return $this->json($response);
    }

    public function logout($request, $response, $args)
    {
        $this->container->Auth->handleLogout($this->code, $this->msg);

        return $this->json($response);
    }
}
?>