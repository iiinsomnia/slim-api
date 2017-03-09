<?php

namespace App\Service;

use App\Dao\MySQL\UserDao;
use Psr\Container\ContainerInterface;

class User extends Service
{
    protected $dao;
    protected $redis;

    function __construct(ContainerInterface $di)
    {
        parent::__construct();

        $this->dao = new UserDao($di);
        $this->redis = $di->get('redis');
    }

    public function handleActionList()
    {
        $data = $this->dao->findAll();
        $this->result['data'] = array_values($data);

        return $this->result;
    }

    public function handleActionDetail($id)
    {
        $cache = $this->redis->hget('user', $id);

        if (!empty($cache)) {
            $this->result['data'] = json_decode($cache);

            return $this->result;
        }

        $data = $this->dao->findById($id);

        if (!$data) {
            $this->result['data'] = [];

            return $this->result;
        }

        $this->redis->hset('user', $id, json_encode($data));
        $this->result['data'] = $data;

        return $this->result;
    }

    public function handleActionAdd($data)
    {
        $row = $this->dao->insert($data);

        if (!$row) {
            $this->result['code'] = -1;
            $this->result['msg'] = 'failed';

            return $this->result;
        }

        $this->result['data'] = $row;

        return $this->result;
    }

    public function handleActionUpdate($id, $data)
    {
        $result = $this->dao->updateById($id, $data);

        if (!$result) {
            $this->result['code'] = -1;
            $this->result['msg'] = 'failed';
        }

        return $this->result;
    }

    public function handleActionDelete($id)
    {
        $result = $this->dao->deleteById($id);

        if (!$result) {
            $this->result['code'] = -1;
            $this->result['msg'] = 'failed';
        }

        return $this->result;
    }
}
?>