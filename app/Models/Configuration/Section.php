<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;
    
    protected $table = 'sections';

    protected $fillable = [
        'grade_level',
        'name'
    ];

    public function students()
    {
        return $this->hasMany('App\Models\StudentSection', 'section_id');
    }

    /* public function getYearSection()
    {
        $year = "";
        $section = "";
        if(isset($this->id)){
            if($this->stage == 'secondary'){
                $year = "Grade " . ($this->grade_level + 6);
            }
            elseif($this->stage == 'tertiary'){
                $year = $this->ordinal($this->grade_level)." Year";
            }
            $section = $this->name;
        }
        return $year." ".$section;
    }

    public function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    } */
}
