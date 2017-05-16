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
        $articleDao = new ArticleDao($this->container);
        $dbData = $articleDao->getAll();

        $resData = $dbData;

        return;
    }

    // 处理文章详情请求
    public function handleActionDetail($id, &$resCode, &$resMsg, &$resData)
    {
        $articleCache = new ArticleCache($this->container);
        $cacheData = $articleCache->getCacheById($id);

        if (!empty($cacheData)) {
            $resData = $cacheData;
            return;
        }

        $articleDao = new ArticleDao($this->container);
        $dbData = $articleDao->getById($id);

        if (empty($dbData)) {
            $resData = null;
            return;
        }

        $articleCache->setCacheById($id, $dbData);

        $resData = $dbData;

        return;
    }

    // 处理文章添加请求
    public function handleActionAdd($postData, &$resCode, &$resMsg, &$resData)
    {
        $articleDao = new ArticleDao($this->container);
        $id = $articleDao->addNew($postData);

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
        $articleCache = new ArticleCache($this->container);
        $articleCache->delCacheById($id);

        $articleDao = new ArticleDao($this->container);
        $result = $articleDao->updateById($id, $putData);

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
        $articleCache = new ArticleCache($this->container);
        $articleCache->delCacheById($id);

        $articleDao = new ArticleDao($this->container);
        $result = $articleDao->deleteById($id);

        if (!$result) {
            $resCode = -1;
            $resMsg = 'failed';
        }

        return;
    }
}
?>