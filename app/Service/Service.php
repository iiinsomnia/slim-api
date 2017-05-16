<?php
namespace App\Service;

use App\Cache\AuthCache;
use Psr\Container\ContainerInterface;

class Service
{
    protected $container;

    function __construct(ContainerInterface $c)
    {
        $this->container = $c;
    }

    protected function getUserId($uuid)
    {
        $authCache = new AuthCache($this->container);
        $loginInfo = $authCache->getAuthCache($uuid);

        if (empty($loginInfo)) {
            return 0;
        }

        return $loginInfo['user_id'];
    }

    protected function getUserInfo($uuid)
    {
        $authCache = new AuthCache($this->container);
        $loginInfo = $authCache->getAuthCache($uuid);

        if (empty($loginInfo)) {
            return [];
        }

        return $loginInfo;
    }
}
?>