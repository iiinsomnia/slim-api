<?php
namespace App\Service\V1;

use App\Service\Service;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator as v;

class Book extends Service
{
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    public function rules()
    {
        return [
            'title' => [
                'label'    => '书名',
                'required' => true,
            ],
            'author' => [
                'label'    => '作者',
                'required' => true,
            ],
            'version' => [
                'label'    => '版本',
                'required' => true,
            ],
            'price' => [
                'label'    => '价格',
                'required' => true,
            ],
            'publisher' => [
                'label'    => '出版社',
                'required' => true,
            ],
            'publish_date' => [
                'label'    => '出版日期',
                'required' => true,
            ],
        ];
    }

    // 处理书籍列表请求
    public function handleList(&$code, &$msg, &$resp)
    {
        $dbData = $this->container->BookDao->getAll();

        $resp = $dbData;

        return;
    }

    // 处理书籍详情请求
    public function handleDetail($id, &$code, &$msg, &$resp)
    {
        $cacheData = $this->container->BookCache->getBookById($id);

        if (!empty($cacheData)) {
            $resp = $cacheData;
            return;
        }

        $dbData = $this->container->BookDao->getById($id);

        if (empty($dbData)) {
            $resp = null;
            return;
        }

        $this->container->BookCache->setBookById($id, $dbData);

        $resp = $dbData;

        return;
    }

    // 处理书籍添加请求
    public function handleAdd($postData, &$code, &$msg, &$resp)
    {
        $id = $this->container->BookDao->addNewRecord($postData);

        if (!$id) {
            $code = -1;
            $msg = 'failed';

            return;
        }

        $resp = $id;

        return;
    }

    // 处理书籍编辑请求
    public function handleUpdate($id, $putData, &$code, &$msg)
    {
        // 删除书籍缓存
        $this->container->BookCache->delBookById($id);

        $result = $this->container->BookDao->updateById($id, $putData);

        if ($result === false) {
            $code = -1;
            $msg = 'failed';
        }

        return;
    }

    // 处理书籍删除请求
    public function handleDelete($id, &$code, &$msg)
    {
        // 删除书籍缓存
        $this->container->BookCache->delBookById($id);

        $result = $this->container->BookDao->deleteById($id);

        if ($result === false) {
            $code = -1;
            $msg = 'failed';
        }

        return;
    }
}
?>