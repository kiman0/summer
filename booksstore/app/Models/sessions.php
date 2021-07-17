<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sessions extends Model
{
    use HasFactory;
    protected $fillable = ['id','payload','last_activity'];
    public $timestamps = false;
    public function products()
    {
        return $this->hasMany('App\Models\help2');
    }
}
