<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
	protected $table = "lists";

    protected $fillable = [
        'title', 'slug', 'user_id', 'global'
    ];

    public function user( ){
    	return $this->belongsTo('App\User');
    }

    public function tasks( ){
    	return $this->hasMany('App\Task');
    }
}
