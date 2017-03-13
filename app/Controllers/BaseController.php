<?php
namespace App\Controllers;

class BaseController
{
    protected $code;
    protected $msg;
    protected $data;

    function __construct() {
        $this->code = 0;
        $this->msg = 'success';
        $this->data = false;
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