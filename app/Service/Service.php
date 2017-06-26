<?php
namespace App\Service;

use Psr\Container\ContainerInterface;

class Service
{
    protected $uid = 0;
    protected $user = [];

    protected $container;

    function __construct(ContainerInterface $c)
    {
        $uuid = $c->request->getHeader('Access-UUID');
        $this->_initUserInfo($c, $uuid[0]);

        $this->container = $c;
    }

    private function _initUserInfo($container, $uuid)
    {
        $loginInfo = $container->AuthCache->getLoginData($uuid);

        if (!empty($loginInfo)) {
            $this->uid = $loginInfo['id'];
            $this->user = $loginInfo;
        }

        return;
    }
}
?>