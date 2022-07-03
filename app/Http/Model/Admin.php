<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    
    // protected $table = 'admin'; // 忽略复数检查

    public function list($keywords = '', $limit = 10)
    {
        return $this->where('name', 'like','%' . $keywords . '%')->paginate($limit);
    }
}
