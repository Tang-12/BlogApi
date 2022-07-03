<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function _success($msg = '', $data = [])
  {
    echo json_encode(['code' => 200, 'msg' => $msg, 'data' => $data], JSON_UNESCAPED_UNICODE); exit;
  }

  public function _error($msg = '', int $code = 400, $data = array())
  {
    echo json_encode(['code'=>$code, 'msg'=>$msg, 'data'=>$data], JSON_UNESCAPED_UNICODE); exit();
  }
}
