<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;
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
      // throw new UnauthorizedHttpException('jwt-auth',json_encode(['status' => 401,'msg' => '未登录']));
        echo (json_encode(['code'=> 401, 'msg'=> '请先登录'])); exit();
    }catch(TokenExpiredException $e){
      try {
        $token = $this->auth->refresh(); //刷新请求token
        Auth::guard('adminApi')->onceUsingId($this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub']);
      } catch (JWTException $exception) {
        // refresh也过期了，需要重新登录
         echo (json_encode(['code'=> 401, 'msg'=> '无效token'])); exit();
      }
    }
    //在响应头中返回新的token
    return $this->setAuthenticationHeader($next($request),$token);
  }
}
