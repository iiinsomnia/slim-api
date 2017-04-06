<?php

namespace App\Service;

use App\Cache\ArticleCache;
use App\Dao\MySQL\UserDao;
use Psr\Container\ContainerInterface;

class Article extends IIInsomnia
{
    private $_di;

    function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $this->_di = $di;
    }

    // 处理文章列表请求
    public function handleActionList(&$resCode, &$resMsg, &$resData)
    {
        $articleDao = new ArticleDao($this->_di);
        $dbData = $articleDao->findAll();

        $resData = array_values($dbData);

        return;
    }

    // 处理文章详情请求
    public function handleActionDetail($id, &$resCode, &$resMsg, &$resData)
    {
        $articleCache = new ArticleCache($this->_di);
        $cacheData = $articleCache->getArticleCache($id);

        if (!empty($cacheData)) {
            $resData = $cacheData;
            return;
        }

        $articleDao = new ArticleDao($this->_di);
        $dbData = $articleDao->findById($id);

        if (!$dbData) {
            $resData = [];
            return;
        }

        $articleCache->setArticleCache($id, $dbData);

        $resData = $dbData;

        return;
    }

    // 处理文章添加请求
    public function handleActionAdd($postData, &$resCode, &$resMsg, &$resData)
    {
        $articleDao = new ArticleDao($this->_di);
        $row = $articleDao->insert($postData);

        if (!$row) {
            $resCode = -1;
            $resMsg = 'failed';

            return;
        }

        $resData = $row;

        return;
    }

    // 处理文章编辑请求
    public function handleActionUpdate($id, $putData, &$resCode, &$resMsg)
    {
        // 删除文章缓存
        $articleCache = new ArticleCache($this->_di);
        $articleCache->delArticleCache($id);

        $articleDao = new ArticleDao($this->_di);
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
        $articleCache = new ArticleCache($this->_di);
        $articleCache->delArticleCache($id);

        $articleDao = new ArticleDao($this->_di);
        $result = $articleDao->deleteById($id);

        if (!$result) {
            $resCode = -1;
            $resMsg = 'failed';
        }

        return;
    }
}
?>