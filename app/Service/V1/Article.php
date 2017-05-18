<?php

namespace App\Service\V1;

use App\Cache\ArticleCache;
use App\Dao\MySQL\ArticleDao;
use App\Service\Service;
use Psr\Container\ContainerInterface;

class Article extends Service
{
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }

    // 处理文章列表请求
    public function handleActionList(&$resCode, &$resMsg, &$resData)
    {
        $dbData = $this->container->ArticleDao->getAll();

        $resData = $dbData;

        return;
    }

    // 处理文章详情请求
    public function handleActionDetail($id, &$resCode, &$resMsg, &$resData)
    {
        $cacheData = $this->container->ArticleCache->getArticleById($id);

        if (!empty($cacheData)) {
            $resData = $cacheData;
            return;
        }

        $dbData = $this->container->ArticleDao->getById($id);

        if (empty($dbData)) {
            $resData = null;
            return;
        }

        $this->container->ArticleCache->setArticleById($id, $dbData);

        $resData = $dbData;

        return;
    }

    // 处理文章添加请求
    public function handleActionAdd($postData, &$resCode, &$resMsg, &$resData)
    {
        $id = $this->container->ArticleDao->addNew($postData);

        if (!$id) {
            $resCode = -1;
            $resMsg = 'failed';

            return;
        }

        $resData = $id;

        return;
    }

    // 处理文章编辑请求
    public function handleActionUpdate($id, $putData, &$resCode, &$resMsg)
    {
        // 删除文章缓存
        $this->container->ArticleCache->delArticleById($id);

        $result = $this->container->ArticleDao->updateById($id, $putData);

        if (!$result) {
            $resCode = -1;
            $resMsg = 'failed';
        }

        return;
    }

    // 处理文章删除请求
    public function handleActionDelete($id, &$resCode, &$resMsg)
    {
        // 删除文章缓存
        $this->container->ArticleCache->delArticleById($id);

        $result = $this->container->ArticleDao->deleteById($id);

        if (!$result) {
            $resCode = -1;
            $resMsg = 'failed';
        }

        return;
    }
}
?>