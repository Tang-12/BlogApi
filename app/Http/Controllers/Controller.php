<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function _success($msg = '', $data = [])
  {
    echo json_encode(['code' => 200, 'msg' => $msg, 'data' => $data], JSON_UNESCAPED_UNICODE);
  }

  public function _error($msg = '', int $code = 400, $data = array())
  {
    echo json_encode(['code'=>$code, 'msg'=>$msg, 'data'=>$data], JSON_UNESCAPED_UNICODE);
  }

  // accuess token get user information
  public function getAuthenticatedInfo()
  {
    try{
      if(!$user = JWTAuth::parseToken()->authenticate()) {
        return $this->_error('user_not_found');
      } 
    }catch(TokenExpiredException $e) {
      return $this->_error('token_expired',$e->getStatusCode());
    }catch(TokenExpiredException $e) {
      return $this->_error('token_invalid', $e->getStatusCode());
    }catch(JWTException $e) {
      return $this->_error('token_absent', $e->getMessage());
    }
    $data = [];
    $data['u_id'] = $user->id; // user id
    $data['u_name'] = $user->name; // user name
    return $data;
  }
}
