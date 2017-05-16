<?php
namespace App\Controllers;

use Psr\Container\ContainerInterface;

class Controller
{
    protected $code;
    protected $msg;
    protected $data;

    protected $container;

    function __construct(ContainerInterface $c) {
        $this->code = 0;
        $this->msg = 'success';
        $this->data = false;

        $this->container = $c;
    }

    public function json($response) {
        $result = [
            'code' => $this->code,
            'msg'  => $this->msg,
        ];

        if ($this->data !== false) {
            $result['data'] = $this->data;
        }

        return $response->withJson($result, 200);
    }
}
?>