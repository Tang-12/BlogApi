<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $request->route()->getName(); 获取当前访问路由
        if(auth()->check())
        {
            return response()->json(['code'=>401, 'msg' => '您未登录!']);
        }
        $redis = new Redis();
        /**
         * 从redis取出允许访问的菜单节点
         */
        // $allow_auth =
        return $next($request);
    }
}
