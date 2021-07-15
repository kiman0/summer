<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    public $timestamps=false;
    Protected $primaryKey = "id";
    public function manbooks()
    {
        return $this->hasMany('App\Models\books');
    }
}
