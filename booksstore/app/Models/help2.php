<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class help2 extends Model
{
    use HasFactory;
    public function mansessions()
    {
        return $this->belongsTo('App\Models\sessions');
    }
}
