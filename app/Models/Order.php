<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'name_main',
        'name_sub',
        'desc',
        'code_order',
        'from',
        'to',
        'GBS',
        'file',
        'user_id'
    ];
 
        
        public function user(){
            return $this->belongsToMany(User::class, 'user__orders','order_id','user_id')->withPivot('status','price');
        }
        
}
