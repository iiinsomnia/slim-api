<?php
namespace App\Service;

use App\Cache\AuthCache;
use Psr\Container\ContainerInterface;

class IIInsomnia
{
    private $_di;

    function __construct(ContainerInterface $di)
    {
        $this->_di = $di;
    }

    protected function getUserId($uuid)
    {
        $authCache = new AuthCache($this->_di);
        $loginInfo = $authCache->getAuthCache($uuid);

        if (empty($loginInfo)) {
            return 0;
        }

        return $loginInfo['user_id'];
    }

    protected function getUserInfo($uuid)
    {
        $authCache = new AuthCache($this->_di);
        $loginInfo = $authCache->getAuthCache($uuid);

        if (empty($loginInfo)) {
            return [];
        }

        return $loginInfo;
    }
}
?>