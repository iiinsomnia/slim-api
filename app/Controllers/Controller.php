<?php
namespace App\Controllers;

use Psr\Container\ContainerInterface;

class Controller
{
    protected $code = 0;
    protected $msg = 'success';
    protected $resp = [];

    protected $container;

    function __construct(ContainerInterface $c) {
        $this->container = $c;
    }

    public function json($response) {
        $result = [
            'code' => $this->code,
            'msg'  => $this->msg,
            'data' => $this->resp,
        ];

        return $response->withJson($result, 200);
    }
}
?>