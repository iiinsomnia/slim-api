<?php
namespace App\Service\V1;

use App\Service\Service;
use Psr\Container\ContainerInterface;

class Student extends Service
{
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    // 处理学生列表请求
    public function handleList(&$code, &$msg, &$resp)
    {
        $dbData = $this->container->StudentDao->getAll();

        $resp = $dbData;

        return;
    }

    // 处理学生详情请求
    public function handleDetail($id, &$code, &$msg, &$resp)
    {
        $dbData = $this->container->StudentDao->getById(['_id' => intval($id)]);

        if (!$dbData) {
            $resp = [];
            return;
        }

        $resp = $dbData;

        return;
    }

    // 处理学生添加请求
    public function handleAdd($postData, &$code, &$msg, &$resp)
    {
        $id = $this->container->StudentDao->addNewRecord($postData);

        if (!$id) {
            $code = -1;
            $msg = 'failed';

            return;
        }

        $resp = $id;

        return;
    }

    // 处理学生编辑请求
    public function handleUpdate($id, $putData, &$code, &$msg)
    {
        $result = $this->container->StudentDao->updateById(['_id' => intval($id)], $resp);

        if (!$result) {
            $code = -1;
            $msg = 'failed';
        }

        return;
    }

    // 处理学生删除请求
    public function handleDelete($id, &$code, &$msg)
    {
        $result = $this->container->StudentDao->deleteById(['_id' => intval($id)]);

        if (!$result) {
            $code = -1;
            $msg = 'failed';
        }

        return;
    }
}
?>