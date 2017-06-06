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

    public function actionLogin($request, $response, $args)
    {
        $uuid = $request->getHeader('Access-UUID');
        $input = $request->getParsedBody();

        $errors = ValidateHelper::validate($input, $this->container->Auth->loginRules());

        if (!empty($errors)) {
            $this->code = -1;
            $this->msg = implode(';', $errors);

            return $this->json($response);;
        }

        $this->container->Auth->handleActionLogin($uuid[0], $input, $this->code, $this->msg, $this->data);

        return $this->json($response);
    }

    public function actionLogout($request, $response, $args)
    {
        $uuid = $request->getHeader('Access-UUID');

        $this->container->Auth->handleActionLogout($uuid[0]);

        return $this->json($response);
    }
}
?>