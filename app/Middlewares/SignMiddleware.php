<?php
namespace App\Middlewares;

use Psr\Container\ContainerInterface;

class SignMiddleware
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
        $accessSign = $request->getHeader('Access-Sign');
        $accessTime = $request->getHeader('Access-Time');
        $uuid = $request->getHeader('Access-UUID');
        $mode = $request->getHeader('Access-Mode');

        if (empty($accessSign) || empty($accessTime) || empty($uuid)) {
            return $response->withJson([
                'code' => 403,
                'msg'  => 'invalid token, access failed!',
            ], 200);
        }

        // 验签
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();

        // debug模式返回签名
        if (!empty($mode) && $mode[0] === 'debug') {
            $sign = $this->_generateSign($uuid[0], $accessTime[0], $path, $query);

            return $response->withJson([
                'code' => $this->code,
                'msg'  => $this->msg,
                'sign' => $sign,
            ], 200);
        }

        $success = $this->auth($uuid[0], $accessTime[0], $accessSign[0], $path, $query);

        if (!$success) {
            return $response->withJson([
                'code' => $this->code,
                'msg'  => $this->msg,
            ], 200);
        }

        $response = $next($request, $response);

        return $response;
    }

    // 验签
    protected function auth($uuid, $accessTime, $accessSign, $path, $query)
    {
        $duration = env('ACCESS_DURATION', 0);

        if (is_numeric($duration) && $duration != 0) {
            if (time() - intval($accessTime) >= $duration) {
                $this->code = -1;
                $this->msg = '请求已失效';

                return false;
            }
        }

        $sign = $this->_generateSign($uuid, $accessTime, $path, $query);

        if (strtolower($accessSign) != $sign) {
            $this->code = -1;
            $this->msg = '验签失败';

            return false;
        }

        return true;
    }

    // 生成签名
    private function _generateSign($uuid, $accessTime, $path, $query)
    {
        $token = $this->container->AuthCache->getLoginToken($uuid);

        array_shift($query);
        $query['token'] = $token;
        $query['timestamp'] = $accessTime;

        $signUrl = sprintf("%s?%s", $path, http_build_query($query));
        $sign = md5($signUrl);

        return $sign;
    }
}