<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class List extends Authenticatable
{

    protected $fillable = [
        'title', 'slug', 'user_id',
    ];

    public function user( ){
    	$this->belongsTo('App\User');
    }

    public function tasks( ){
    	$this->hasMany('App\Task');
    }
}
