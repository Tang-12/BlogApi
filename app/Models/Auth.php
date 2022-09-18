<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auth extends Model
{
  use SoftDeletes; // enable soft deletes
  public $timestamps = true;
  const UPDATED_AT = null;
  const DELETED_AT = 'deleted_time';
  protected function serializeDate(\DateTimeInterface $date)
  {
      return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
  }
}