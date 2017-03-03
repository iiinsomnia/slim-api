<?php

namespace App\Service;

use App\Dao\UserDao;
use Psr\Container\ContainerInterface;

class User
{
    protected $dao;
    protected $redis;

    function __construct(ContainerInterface $di)
    {
        $this->dao = new UserDao($di);
        $this->redis = $di->get('redis');
    }

    public function getDetail($id)
    {
        $data = $this->redis->hget('user', $id);

        if (!empty($data)) {
            return json_decode($data);
        }

        $data = $this->dao->getUserInfoById($id);

        if (!$data) {
            return [];
        }

        $this->redis->hset('user', $id, json_encode($data));

        return $data;
    }

    public function getList()
    {
        $data = $this->dao->getUserList();

        return $data;
    }
}
?>