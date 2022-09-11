<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'fav',
        
        
];
}
