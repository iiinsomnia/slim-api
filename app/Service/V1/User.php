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

    public function handleActionView($uuid, &$code, &$msg, &$resp)
    {
        $userInfo = $this->getUserInfo($uuid);
        $resp = $userInfo;

        return;
    }
}
?>