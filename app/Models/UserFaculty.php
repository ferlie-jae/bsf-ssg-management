<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFaculty extends Model
{
	use SoftDeletes;
    
    protected $table = 'user_faculties';

    protected $fillable = [
        'user_id',
        'faculty_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function faculty(){
        return $this->belongsTo('App\Models\Faculty', 'faculty_id');
    }
}
