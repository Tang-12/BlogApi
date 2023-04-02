<?php

namespace App\Http\Controllers;

use App\Http\Services\IndexService;
use Illuminate\Support\Facades\DB;

class Index extends Controller
{
    public function index()
    {   
        $this->_success('成功');
    }

    /**
     * 获取用户名
     */
    public function info()
    {
        try {
            $data = $this->getAuthenticatedInfo();
            return $this->_success('成功', $data);
        }catch (\Exception $e) {
            return $this->_error($e->getMessage());
        }
    }

    /**
     * 输出菜单列表
     */
    public function menuList()
    {
        try {
            $u_id = $this->getAuthenticatedInfo();
            $user = Db::table('authList')->select('menu_id')->where('auth_id', $u_id['a_id'])->get()->toArray();
            $auth_id = implode(',', $user);
            $indexService = new IndexService();
            $result = $indexService->indexList($auth_id);
            return $this->_success('成功',$result);
        } catch (\Exception $e) {
            return $this->_error($e->getMessage());
        }
    }
}
