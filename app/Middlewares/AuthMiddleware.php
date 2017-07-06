<?php
namespace App\Middlewares;

use Psr\Container\ContainerInterface;

class AuthMiddleware
{
    protected $code = 0;
    protected $msg = 'success';

    protected $container;

    function __construct(ContainerInterface $c) {
        $this->container = $c;
    }

    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $uuid = $request->getHeader('Access-UUID');

        if (empty($uuid)) {
            return $response->withJson([
                'code' => 403,
                'msg'  => 'invalid token, access failed!',
            ], 200);
        }

        // 登录验证
        $success = $this->auth($uuid[0]);

        if (!$success) {
            return $response->withJson([
                'code' => $this->code,
                'msg'  => $this->msg,
            ], 200);
        }

        $response = $next($request, $response);

        return $response;
    }

    // 验证登录
    protected function auth($uuid)
    {
        $loginInfo = $this->container->AuthCache->getLoginData($uuid);

        if (empty($loginInfo)) {
            $this->code = 401;
            $this->msg = '用户未登录';

            return false;
        }

        if ($loginInfo['duration'] != 0) {
            $duration = time() - strtotime($loginInfo['last_login_time']);

            if ($duration >= $loginInfo['duration']) {
                $this->container->AuthCache->logoutByUUID($uuid);

                $this->code = 401;
                $this->msg = '登录已过期';

                return false;
            }
        }

        return true;
    }
}