<?php
namespace App\Cache;

use Psr\Container\ContainerInterface;

class ArticleCache
{
    private $_redis;

    private $_cacheKey = 'article';

    function __construct(ContainerInterface $c)
    {
        $this->_redis = $c->get('redis');
    }

    public function setCacheById($articleId, $data)
    {
        $this->_redis->hset($this->_cacheKey, $articleId, json_encode($data));
    }

    public function getCacheById($articleId)
    {
        $data = $this->_redis->hget($this->_cacheKey, $articleId);

        if (empty($data)) {
            return [];
        }

        return json_decode($data, true);
    }

    public function delCacheById($articleId)
    {
        $this->_redis->hdel($this->_cacheKey, $articleId);
    }
}
?>