<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Order;
use App\Models\Scope;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;


use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject , Wallet
{
    use HasApiTokens, HasFactory, Notifiable, HasWallet;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
            'first_name' ,
            'last_name',
            'email' ,
            'phone',
            'city',
            'date',
            'code',
            'status',
            'ID_number',
            'role',
            'ID_number',
            'ID_img',
            'scope',
            'about',
            'Bank_Number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }    

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function scops(){
        return $this->hasMany(Scope::class, 'user_id');

    }
    public function order(){
        return $this->belongsToMany(Order::class, 'user__orders','user_id','order_id')->withPivot('status','price');
    }
    public function fav(){
        return $this->belongsToMany(Order::class, 'fav_orders','user_id','order_id')->withPivot('fav');
    }
}
