<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
  use SoftDeletes;
  public $timestamps = true;
  const UPDATED_AT = null;
  const DELETED_AT = 'deleted_time';

  public function articles()
  {
    return $this->hasMany('App\models\Article', 'u_id');
  }

  /**
   * 为数组 / JSON 序列化准备日期。
   *
   * @param  \DateTimeInterface  $date
   * @return string
   */
  protected function serializeDate(\DateTimeInterface $date)
  {
    return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
  }
}
