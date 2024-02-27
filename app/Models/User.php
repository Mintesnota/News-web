<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;






class User extends Authenticatable implements MustVerifyEmail
{    
    
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        
        'name',
        'email',
        'password',
        'is_writer',
        'is_admin',
        'country',
        'phone',
        'address',
        'image',
        'profession',
        'bio',
        'state',
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
        'password' => 'hashed',
    ];

    public function category(){
        return $this->hasMany('App\Models\Category');

    }
    public function posts(){
        return $this->hasMany('App\Models\Post');
    }

    public function writer()
    {
        return $this->hasOne('App\Models\writer');

    }
    public function advert()
    {
        return $this->hasOne('App\Models\Advertise');
    }
    
    public function Videos(){
        return $this->hasMany('App\Modles\Video');
    }


}

