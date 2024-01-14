<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class writer extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'phone'
    ];

    public function user(){
        return $this-> belongsTo('App\Models\user');
    }

    public function advert(){
        return $this-> belongsTo('App\Models\user');
    }
}
