<?php
namespace App\Service;

use App\Cache\AuthCache;
use Psr\Container\ContainerInterface;

class Service
{
    private $_userID = 0;
    private $_userInfo = [];

    protected $container;

    function __construct(ContainerInterface $c)
    {
        $this->_initUserInfo();

        $this->container = $c;
    }

    private function _initUserInfo($uuid)
    {
        $loginInfo = $this->container->AuthCache->getAuthData($uuid);

        if (!empty($loginInfo)) {
            $this->_userID = $loginInfo['id'];
            $this->_userInfo = $loginInfo;
        }

        return;
    }
}
?>