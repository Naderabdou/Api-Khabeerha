<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Scope extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_main',
        'name_sub',
        'file',
        'user_id'
    ];
    public function User(){
        return $this->belongsto(User::class, 'user_id');

    }
}
