<?php
namespace App\Service;

use Psr\Container\ContainerInterface;

class User extends IIInsomnia
{
    private $_di;

    function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $this->_di = $di;
    }

    public function handleActionView($uuid, &$resCode, &$resMsg, &$resData)
    {
        $userInfo = $this->getUserInfo($uuid);
        $resData = $userInfo;

        return;
    }
}
?>