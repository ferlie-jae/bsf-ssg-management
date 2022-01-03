<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class StudentSection extends Model
{
	use SoftDeletes;
    
    protected $table = 'student_sections';

    protected $fillable = [
        'section_id',
        'student_id'
    ];

    public function student(){
        if(Auth::user()->hasrole('System Administrator')){
            return $this->belongsTo('App\Models\Student', 'student_id')->withTrashed();
        }
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    public function section(){
        return $this->belongsTo('App\Models\Configuration\Section', 'section_id');
    }
}
