<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Task extends Authenticatable
{

    protected $fillable = [
        'description', 'list_id', 'done'
    ];

    public function list( ){
    	$this->belongsTo('App\List');
    }
}
