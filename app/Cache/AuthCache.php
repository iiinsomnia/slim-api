<?php
namespace App\Cache;

use Psr\Container\ContainerInterface;

class AuthCache
{
    private $_cacheCookieKey = "auth:cookie";
    private $_cacheSessionKey = "auth:session";
    private $_cacheDeviceKey = "auth:device";

    protected $redis;

    function __construct(ContainerInterface $c)
    {
        $this->redis = $c->get('redis');
    }

    // 设置登录验证用户信息缓存，token相当于sessionID
    public function setLoginData($phone, $uuid, $token, $data)
    {
        $this->redis->hset($this->_cacheDeviceKey, $phone, $uuid);
        $this->redis->hset($this->_cacheCookieKey, $uuid, $token);
        $this->redis->hset($this->_cacheSessionKey, $token, json_encode($data));

        return;
    }

    // 获取登录验证后的用户信息
    public function getLoginData($uuid)
    {
        $token = $this->redis->hget($this->_cacheCookieKey, $uuid);

        if (empty($token)) {
            return [];
        }

        $data = $this->redis->hget($this->_cacheSessionKey, $token);

        if (empty($data)) {
            return [];
        }

        $loginInfo = json_decode($data, true);

        return $loginInfo;
    }

    // 获取用户登录的唯一token
    public function getLoginToken($uuid)
    {
        $token = $this->redis->hget($this->_cacheCookieKey, $uuid);

        return $token;
    }

    // 用于注销上一台设备登录验证的信息
    public function logoutByPhone($phone)
    {
        $uuid = $this->redis->hget($this->_cacheDeviceKey, $phone);
        $token = $this->redis->hget($this->_cacheCookieKey, $uuid);

        $this->redis->hdel($this->_cacheSessionKey, $token);
        $this->redis->hdel($this->_cacheCookieKey, $uuid);

        return;
    }

    // 用于注销本次登录验证信息
    public function logoutByUUID($uuid)
    {
        $token = $this->redis->hget($this->_cacheCookieKey, $uuid);

        $this->redis->hdel($this->_cacheSessionKey, $token);
        $this->redis->hdel($this->_cacheCookieKey, $uuid);

        return;
    }
}
?>