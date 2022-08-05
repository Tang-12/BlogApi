<?php

namespace App\Http\Controllers;

use App\Http\Services\IndexService;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Driver\Selector;

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
            $indexService = new IndexService();
            $result = $indexService->indexList();
            return $this->_success('成功',$result);
        } catch (\Exception $e) {
            return $this->_error($e->getMessage());
        }
    }
}
