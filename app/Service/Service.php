<?php
namespace App\Service;

use Psr\Container\ContainerInterface;

class Service
{
    protected $uid = 0;
    protected $user = [];

    protected $container;
    protected $uuid;

    function __construct(ContainerInterface $c, $uuid)
    {
        $this->_initUserInfo($c, $uuid);

        $this->container = $c;
        $this->uuid = $uuid;
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