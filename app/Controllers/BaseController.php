<?php
namespace App\Controllers;

class BaseController
{
    public function json($response, $code, $msg, $data = false) {
        $result = [
            'code' => $code,
            'msg'  => $msg,
        ];

        if ($data !== false) {
            $result['data'] = $data;
        }

        return $response->withJson($result, 200);
    }
}
?>