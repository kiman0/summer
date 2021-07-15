<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class books extends Model
{
    use HasFactory;
    public $timestamps=false;
    public $categories_id=false;
    Protected $primaryKey = "id";
    public function mancategories()
    {
        return $this->belongsTo('App\Models\categories');
    }
}
