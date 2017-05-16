<?php
namespace App\Service\V1;

use App\Service\Service;
use Psr\Container\ContainerInterface;

class User extends Service
{
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    public function handleActionView($uuid, &$resCode, &$resMsg, &$resData)
    {
        $userInfo = $this->getUserInfo($uuid);
        $resData = $userInfo;

        return;
    }
}
?>