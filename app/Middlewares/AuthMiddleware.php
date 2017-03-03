<?php
namespace App\Middlewares;

class AuthMiddleware
{
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
        $accessToken = $request->getHeader('Access-Token');

        if (empty($accessToken) || $accessToken[0] != '123456789') {
            return $response->withJson([
                'code' => -1,
                'msg' => 'Invalid token, access failed!',
            ], 200);
        }

        $response = $next($request, $response);

        return $response;
    }
}