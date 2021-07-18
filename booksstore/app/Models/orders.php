<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_id', 'name', 'surname', 'patronymic', 'telephone',
        'total_price',
        'email',
        'address',];
    use HasFactory;
}
