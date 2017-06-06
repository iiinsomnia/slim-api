<?php

namespace App\Service\V1;

use App\Dao\Mongo\BookDao;
use App\Service\Service;
use Psr\Container\ContainerInterface;

class Book extends Service
{
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    // 处理书籍列表请求
    public function handleActionList(&$code, &$msg, &$resp)
    {
        $dbData = $this->container->BookDao->getAll();

        $resp = $dbData;

        return;
    }

    // 处理书籍详情请求
    public function handleActionDetail($id, &$code, &$msg, &$resp)
    {
        $dbData = $this->container->BookDao->getById(['_id' => intval($id)]);

        if (!$dbData) {
            $resp = [];
            return;
        }

        $resp = $dbData;

        return;
    }

    // 处理书籍添加请求
    public function handleActionAdd($postData, &$code, &$msg, &$resp)
    {
        $id = $this->container->BookDao->addNew($postData);

        if (!$id) {
            $code = -1;
            $msg = 'failed';

            return;
        }

        $resp = $id;

        return;
    }

    // 处理书籍编辑请求
    public function handleActionUpdate($id, $putData, &$code, &$msg)
    {
        $result = $this->container->BookDao->updateById(['_id' => intval($id)], $resp);

        if (!$result) {
            $code = -1;
            $msg = 'failed';
        }

        return;
    }

    // 处理书籍删除请求
    public function handleActionDelete($id, &$code, &$msg)
    {
        $result = $this->container->BookDao->deleteById(['_id' => intval($id)]);

        if (!$result) {
            $code = -1;
            $msg = 'failed';
        }

        return;
    }
}
?>