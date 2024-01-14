<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'category_id',
        'user_id',
        'short_desc',
        'special',
        'image',
        'long_desc',
        'breaking',
        'views',


    ];
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    public function user(){
        return $this->belongsTo('App\Models\user');
    }
    public function tags(){
        return $this->hasMany('App\Models\Tag');
    }
}
