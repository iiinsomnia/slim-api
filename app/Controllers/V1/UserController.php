<?php
namespace App\Controllers\V1;

use App\Controllers\Controller;
use App\Service\V1\User;
use Psr\Container\ContainerInterface;

class UserController extends Controller
{
    // constructor receives container instance
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }
}
?>