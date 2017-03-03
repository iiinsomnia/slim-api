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

    public function detail($request, $response, $args) {
        $data = $this->user->getDetail(1);

        return $this->json($response, 0, 'success', $data);
    }

    public function list($request, $response, $args) {
        $data = $this->user->getList();

        return $this->json($response, 0, 'success', $data);
    }
}
?>