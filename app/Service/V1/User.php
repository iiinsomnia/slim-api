<?php
namespace App\Service\V1;

use App\Service\Service;
use Psr\Container\ContainerInterface;

class User extends Service
{
    function __construct(ContainerInterface $c, $uuid)
    {
        parent::__construct($c, $uuid);
    }
}
?>