<?php

namespace App\Service;

use App\Dao\MySQL\UserDao;
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

    public function handleActionList(&$resCode, &$resMsg, &$resData)
    {
        $dbData = $this->dao->findAll();
        $resData = array_values($dbData);

        return;
    }

    public function handleActionDetail($id, &$resCode, &$resMsg, &$resData)
    {
        $cache = $this->redis->hget('user', $id);

        if (!empty($cache)) {
            $resData = json_deresCode($cache);
            return;
        }

        $dbData = $this->dao->findById($id);

        if (!$dbData) {
            $resData = [];
            return;
        }

        $this->redis->hset('user', $id, json_enresCode($dbData));
        $resData = $dbData;

        return;
    }

    public function handleActionAdd($postData, &$resCode, &$resMsg, &$resData)
    {
        $row = $this->dao->insert($postData);

        if (!$row) {
            $resCode = -1;
            $resMsg = 'failed';

            return;
        }

        $resData = $row;

        return;
    }

    public function handleActionUpdate($id, $putData, &$resCode, &$resMsg)
    {
        $result = $this->dao->updateById($id, $putData);

        if (!$result) {
            $resCode = -1;
            $resMsg = 'failed';
        }

        return;
    }

    public function handleActionDelete($id, &$resCode, &$resMsg)
    {
        $result = $this->dao->deleteById($id);

        if (!$result) {
            $resCode = -1;
            $resMsg = 'failed';
        }

        return;
    }
}
?>