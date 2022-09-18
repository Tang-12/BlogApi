<?php
namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Http\Services\MenuService; 

class Menu extends Controller
{

  public function menuNav()
  {
    try {
      $menu = new MenuService();
      $list = $menu->nav();
      return $this->_success('成功', $list);
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  /**
   * 菜单列表
   * @url adminApi/v1/auth/list
   * Request method: POST
   * @param string $title
   * @param number $limit
   * @return string HTTP response code 200 success  400 fail code
   */
  public function menuList(MenuRequest $request)
  {
    try {
      $menuService = new MenuService();
      $data = $menuService->list();
      return $this->_success('成功', $data);
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  /**
   * 添加菜单
   * @url adminApi/v1/auth/create
   * Request method: POST
   * @param number pid
   * @param number is_nav
   * @param string $title
   * @return string HTTP response code 200 success  400 fail code
   */
  public function createMenu(MenuRequest $request)
  {
    $request->validate('add');
    try {
      $pid = $request->input('pid');
      $name = $request->input('name');
      $icon = $request->input('icon');
      $path = $request->input('path');
      $controller = $request->input('controller');
      $methods = $request->input('methods');
      $is_nav = $request->input('is_nav');
      $menuServices = new MenuService();
      $menuServices->createMenu($pid, $name, $icon, $path, $controller, $methods,$is_nav);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage()); // TODO: throw exception
    }
  }

  /**
   * 修改菜单
   * @url adminApi/v1/auth/update
   * Request method: POST
   * @param number id
   * @param number pid
   * @param number is_nav
   * @param string $title
   * @return string HTTP response code 200 success  400 fail code
   */
  public function updateMenu(MenuRequest $request)
  {
    $request->validate('update');
    try{
      $id = $request->input('id');
      $pid = $request->input('pid', 0);
      $name = $request->input('name');
      $icon = $request->input('icon');
      $path = $request->input('path');
      $controller = $request->input('controller');
      $methods = $request->input('methods');
      $is_nav = $request->input('is_nav');
      $menuServices = new MenuService();
      $menuServices->updateMenu($id, $pid, $name, $icon, $path, $controller, $methods, $is_nav);
      return $this->_success('成功');
    }catch(\Exception $e){
      return $this->_error($e->getMessage()); // error messages
    }
  }

  /**
   * 菜单状态
   * @url adminApi/v1/auth/status
   * Request method: GET
   * @param number id
   * @return string HTTP response code 200 success  400 fail code
   */
  public function menuStatus(MenuRequest $request)
  {
    try{
      $request->validate('status');
      $id = $request->get('id');
      $menuService = new MenuService();
      $menuService->changeStatus($id);
      return $this->_success('成功');
    }catch(\Exception $e){
      return $this->_error($e->getMessage()); // Error message
    }
  }

  /**
   * 删除菜单
   * @url adminApi/v1/auth/delete
   * Request method: GET
   * @param array id
   * @return string HTTP response code 200 success  400 fail code
   */
  public function deletedMenu(MenuRequest $request)
  {
    try {
      $request->validate('deleted');
      $id = $request->get('id');
      $menuService = new MenuService();
      $menuService->deletedMenu($id);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  public function infoMenu(MenuRequest $request)
  {
    $request->validate('info');
    try {
      $id = $request->input('id');
      $result =\App\Models\Menu::where(['id'=> $id])->select('id', 'pid', 'name', 'icon', 'path', 'controller', 'methods', 'is_nav')->first();
      return $this->_success('成功', $result);
    }catch (\Exception $e){
      return $this->_error($e->getMessage());
    }
  }

}
