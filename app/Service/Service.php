<?php

namespace App\Service;

class Service
{
    protected $result;

    function __construct()
    {
        $this->result = [
            'code' => 0,
            'msg'  => 'success',
            'data' => false,
        ];
    }
}
?>