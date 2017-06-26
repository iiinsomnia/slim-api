<?php
namespace App\Cache;

use Psr\Container\ContainerInterface;

class BookCache
{
    private $_cacheKey = 'book';

    protected $redis;

    function __construct(ContainerInterface $c)
    {
        $this->redis = $c->get('redis');
    }

    public function setBookById($bookId, $data)
    {
        $this->redis->hset($this->_cacheKey, $bookId, json_encode($data));
    }

    public function getBookById($bookId)
    {
        $data = $this->redis->hget($this->_cacheKey, $bookId);

        if (empty($data)) {
            return [];
        }

        return json_decode($data, true);
    }

    public function delBookById($bookId)
    {
        $this->redis->hdel($this->_cacheKey, $bookId);
    }
}
?>