<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'description', 'list_id', 'done'
    ];

    public function list( ){
    	return $this->belongsTo('App\TaskList');
    }
}
