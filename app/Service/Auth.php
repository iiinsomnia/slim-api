<?php
namespace App\Service;

use Psr\Container\ContainerInterface;

class Auth
{
    protected $container;

    function __construct(ContainerInterface $di)
    {
        $this->container = $di;
    }

    public function loginRules()
    {
        return [
            'phone' => [
                'label'    => '手机号',
                'required' => true,
            ],
            'password' => [
                'label'    => '密码',
                'required' => true,
            ],
        ];
    }

    // 处理登录请求
    public function handleActionLogin($uuid, $input, &$code, &$msg, &$resp)
    {
        $dbData = $this->container->UserDao->getByPhone($input['phone']);

        if (!$dbData) {
            $code = -1;
            $msg = "用户不存在";

            return;
        }

        if (md5($input['password'] . $dbData['salt']) != $dbData['password']) {
            $code = -1;
            $msg = "密码不正确";

            return;
        }

        // 注销上一次登录信息
        $this->container->AuthCache->logoutByPhone($input['phone']);

        $token = $this->signIn($uuid, $dbData);

        $resp = ['token' => $token];

        return;
    }

    // 处理退出请求
    public function handleActionLogout($uuid)
    {
        $this->container->AuthCache->logoutByUUID($uuid);

        return;
    }

    // 用户登录并返回唯一token
    protected function signIn($uuid, $data, $duration = 0)
    {
        $loginIP = $_SERVER['REMOTE_ADDR'];
        $loginTime = date('Y-m-d H:i:s');

        $token = md5($data['id'] . $data['phone'] . $loginIP . $loginTime);

        $data['last_login_ip'] = $loginIP;
        $data['last_login_time'] = $loginTime;
        $data['duration'] = $duration;

        $this->container->AuthCache->setAuthData($data['phone'], $uuid, $token, $data);

        return $token;
    }
}
?>