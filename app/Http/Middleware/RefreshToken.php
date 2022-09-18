<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class RefreshToken extends BaseMiddleware
{
  public function handle($request, Closure $next)
  {
    $this->checkForToken($request); // 检查是否携带token，没有抛出异常
    try{
      //检测用户登录状态，如果正常，则通过
      if($this->auth->parseToken()->authenticate()){
        return $next($request);
      }
        echo (json_encode(['code'=> 403, 'msg'=> '请先登录'])); exit();
    }catch(TokenExpiredException $e){
      try {
        $token = $this->auth->refresh(); //刷新请求token
      } catch (JWTException $exception) {
        echo (json_encode(['code'=> 403, 'msg'=> '无效token'])); exit();
      }
    }
    //在响应头中返回新的token
    return $this->setAuthenticationHeader($next($request),$token);
  }
}
