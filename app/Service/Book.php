<?php

namespace App\Service;

use App\Dao\Mongo\BookDao;
use Psr\Container\ContainerInterface;

class Book extends Service
{
    protected $dao;

    function __construct(ContainerInterface $di)
    {
        parent::__construct();

        $this->dao = new BookDao($di);
        $this->redis = $di->get('redis');
    }

    public function handleActionList()
    {
        $data = $this->dao->find();
        $this->result['data'] = $data;

        return $this->result;
    }

    public function handleActionDetail($id)
    {
        $data = $this->dao->findOne(['_id' => intval($id)]);

        if (!$data) {
            $this->result['data'] = [];

            return $this->result;
        }

        $this->result['data'] = $data;

        return $this->result;
    }

    public function handleActionAdd($data)
    {
        $id = $this->dao->insertOne($data);

        if (!$id) {
            $this->result['code'] = -1;
            $this->result['msg'] = 'failed';

            return $this->result;
        }

        $this->result['data'] = $id;

        return $this->result;
    }

    public function handleActionUpdate($id, $data)
    {
        $result = $this->dao->updateOne(['_id' => intval($id)], $data);

        if (!$result) {
            $this->result['code'] = -1;
            $this->result['msg'] = 'failed';
        }

        return $this->result;
    }

    public function handleActionDelete($id)
    {
        $result = $this->dao->deleteOne(['_id' => intval($id)]);

        if (!$result) {
            $this->result['code'] = -1;
            $this->result['msg'] = 'failed';
        }

        return $this->result;
    }
}
?>