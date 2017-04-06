<?php
namespace App\Middlewares;

class HeaderMiddleware
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
        $uuid = $request->getHeader('Access-UUID');

        if (empty($uuid) || trim($uuid[0]) == '') {
            return $response->withJson([
                'code' => -1,
                'msg' => 'Invalid token, access failed!',
            ], 200);
        }

        $response = $next($request, $response);

        return $response;
    }
}