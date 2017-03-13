<?php

namespace App\Service;

use App\Dao\Mongo\BookDao;
use Psr\Container\ContainerInterface;

class Book
{
    protected $dao;

    function __construct(ContainerInterface $di)
    {
        $this->dao = new BookDao($di);
        $this->redis = $di->get('redis');
    }

    public function handleActionList(&$resCode, &$resMsg, &$resData)
    {
        $dbData = $this->dao->find();
        $resData = $dbData;

        return;
    }

    public function handleActionDetail($id, &$resCode, &$resMsg, &$resData)
    {
        $dbData = $this->dao->findOne(['_id' => intval($id)]);

        if (!$dbData) {
            $resData = [];
            return;
        }

        $resData = $dbData;

        return;
    }

    public function handleActionAdd($postData, &$resCode, &$resMsg, &$resData)
    {
        $id = $this->dao->insertOne($postData);

        if (!$id) {
            $resCode = -1;
            $resMsg = 'failed';

            return;
        }

        $resData = $id;

        return;
    }

    public function handleActionUpdate($id, $putData, &$resCode, &$resMsg)
    {
        $result = $this->dao->updateOne(['_id' => intval($id)], $resData);

        if (!$result) {
            $resCode = -1;
            $resMsg = 'failed';
        }

        return;
    }

    public function handleActionDelete($id, &$resCode, &$resMsg)
    {
        $result = $this->dao->deleteOne(['_id' => intval($id)]);

        if (!$result) {
            $resCode = -1;
            $resMsg = 'failed';
        }

        return;
    }
}
?>