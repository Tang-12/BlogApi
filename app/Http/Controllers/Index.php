<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Driver\Selector;

class Index extends Controller
{
    public function index()
    {   
        $this->_success('成功');
    }
}
