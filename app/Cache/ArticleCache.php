<?php
namespace App\Cache;

use Psr\Container\ContainerInterface;

class ArticleCache
{
    private $_redis;

    private $_cacheKey = 'article';

    function __construct(ContainerInterface $di)
    {
        $this->_redis = $di->get('redis');
    }

    public function setArticleCache($articleId, $data)
    {
        $this->_redis->hset($this->_cacheKey, $articleId, json_encode($data));
    }

    public function getArticleCache($articleId)
    {
        $data = $this->_redis->hget($this->_cacheKey, $articleId);

        if (empty($data)) {
            return [];
        }

        return json_decode($data, true);
    }

    public function delArticleCache($articleId)
    {
        $this->_redis->hdel($this->_cacheKey, $articleId);
    }
}
?>