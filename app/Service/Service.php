<?php
namespace App\Service;

use Psr\Container\ContainerInterface;

class Service
{
    protected $user;
    protected $container;

    function __construct(ContainerInterface $c)
    {
        $this->user = new Identity;
        $this->container = $c;

        $this->_initIdentity();
    }

    private function _initIdentity()
    {
        $uuid = $this->container->request->getHeader('Access-UUID');

        if (empty($uuid)) {
            return;
        }

        $loginInfo = $this->container->AuthCache->getLoginData($uuid[0]);

        if (empty($loginInfo)) {
            return;
        }

        foreach ($loginInfo as $k => $v) {
            $this->user->$k = $v;
        }

        return;
    }
}
?>