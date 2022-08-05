<?php
namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Services\CategoryService;

class Category extends Controller
{
  public function CategoryList(CategoryRequest $request)
  {
    $request->validate('list');
    try {
      $title = $request->input('title');
      $categoryService = new CategoryService();
      $data = $categoryService->list($title);
      return $this->_success('成功', $data);
    } catch (\Exception $e) {
      return $this->_error($e->getMessage()); //错误信息
    }
  }

  public function createdCategory(CategoryRequest $request)
  {
    $request->validate('created');
    try {
      $pid = $request->input('pid', 0);
      $title = $request->input('title');
      $categoryService = new CategoryService();
      $categoryService->created($pid, $title);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage()); // TODO 
    }
  }

  public function updatedCategory(CategoryRequest $request)
  {
    $request->validate('updated');
    try {
      $id = $request->input('id');
      $pid = $request->input('pid', 0);
      $title = $request->input('title');
      $categoryService = new CategoryService();
      $categoryService->update($id, $pid, $title);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  public function categoryStatus(CategoryRequest $request)
  {
    $request->validate('status');
    try{
      $id = $request->input('id');
      $categoryService = new CategoryService();
      $categoryService->status($id);
      return $this->_success('成功');
    }catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  public function categoryDelete(CategoryRequest $request)
  {
    $request->validate('deleted');
    try{
      $id = $request->input('id');
      $categoryService = new CategoryService();
      $categoryService->deleted($id);
      return $this->_success('成功');
    }catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }
}