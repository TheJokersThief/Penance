<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'description', 'list_id', 'done'
    ];

    public function tasklist( ){
    	return $this->belongsTo('App\TaskList');
    }
}
