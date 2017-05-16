<?php

namespace App\Service;

use App\Cache\AuthCache;
use App\Dao\MySQL\UserDao;
use Psr\Container\ContainerInterface;

class Auth
{
    private $container;

    function __construct(ContainerInterface $di)
    {
        $this->container = $di;
    }

    // 处理登录请求
    public function handleActionLogin($uuid, $postData, &$resCode, &$resMsg, &$resData)
    {
        if (!isset($postData['phone']) || trim($postData['phone']) == '') {
            $resCode = -1;
            $resMsg = "手机号不可为空";

            return;
        }

        if (!isset($postData['password']) || trim($postData['password']) == '') {
            $resCode = -1;
            $resMsg = "密码不可为空";

            return;
        }

        $userDao = new UserDao($this->container);
        $userDbData = $userDao->getByPhone($postData['phone']);

        if (!$userDbData) {
            $resCode = -1;
            $resMsg = "用户不存在";

            return;
        }

        if ($userDbData['status'] == 0) {
            $resCode = -1;
            $resMsg = "用户已失效";

            return;
        }

        if ($userDbData['password'] != md5($postData['password'] . $userDbData['salt'])) {
            $resCode = -1;
            $resMsg = "密码不正确";

            return;
        }

        // 注销上一次登录信息
        $authCache = new AuthCache($this->container);
        $authCache->delAuthCacheByPhone($postData['phone']);

        $token = $this->signin($uuid, $userDbData);

        $resData = ['token' => $token];

        return;
    }

    // 处理退出请求
    public function handleActionLogout($uuid)
    {
        $authCache = new AuthCache($this->container);
        $authCache->delAuthCacheByUuid($uuid);

        return;
    }

    // 用户登录并返回唯一token
    protected function signin($uuid, $userDbData)
    {
        $now = time();

        $token = md5($userDbData['id'] . $userDbData['phone'] . $now);

        $expireTime = 0;
        $sessionExpire = env('SESSION_EXPIRE', 0);

        if (is_numeric($sessionExpire) && $sessionExpire > 0) {
            $expireTime = $now + intval($sessionExpire);
        }

        $cacheData = [
            'user_id'     => intval($userDbData['id']),
            'user_name'   => $userDbData['name'],
            'user_phone'  => $userDbData['phone'],
            'login_time'  => $now,
            'expire_time' => $expireTime,
        ];

        $authCache = new AuthCache($this->container);
        $authCache->setAuthCache($userDbData['phone'], $uuid, $token, $cacheData);

        return $token;
    }
}
?>