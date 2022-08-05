<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
  use SoftDeletes; // enable soft deletes
  public $timestamps = true; // auth write timestamps
  const UPDATED_AT = null;
  const DELETED_AT = 'deleted_time';
}