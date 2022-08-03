<?php
namespace App\Http\Middleware;
 
use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class EnableCrossRequest extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $origin     = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';
        $originHost = parse_url($origin, PHP_URL_HOST);
        $originPort = parse_url($origin, PHP_URL_PORT);
        $originHost .= $originPort ? ':' . $originPort : '';
 
        // 允许跨域的域名 可以加在配置里
        $allowOriginHost = [
            'http://localhost',
        ];
 
        $response = $next($request);
        if (in_array($originHost, $allowOriginHost)) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN, Last-Modified');
            $response->header('Access-Control-Expose-Headers', 'Authorization');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
            $response->header('Access-Control-Allow-Credentials', 'true');
        }
        return $response;
    }
}