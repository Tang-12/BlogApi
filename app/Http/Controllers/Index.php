<?php

namespace App\Http\Controllers;

use App\Http\Model\Admin;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Driver\Selector;

class Index extends Controller
{
    public function index()
    {  
        $admin = new Admin();
        $data = $admin->list();
        $this->_success('成功', $data);
    }
}
