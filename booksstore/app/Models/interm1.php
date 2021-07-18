<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class interm1 extends Model
{public $timestamps=false;
    protected $fillable = ['ord_id', 'boo_id','quantity'];
    use HasFactory;
}
