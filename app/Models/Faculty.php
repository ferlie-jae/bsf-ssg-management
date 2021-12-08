<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'faculty_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birth_date',
        'contact_number',
        'address'
    ];

    public function user() {
        return $this->hasOne('App\Models\UserFaculty', 'faculty_id');
    }

    public function getFacultyName()
	{
		$faculty = self::find($this->id);
		$name = "N/A";
		if($faculty){
			$name = $faculty->first_name.' '.
				(is_null($faculty->middle_name) ? '' : $faculty->middle_name[0].'. ').
				$faculty->last_name;
		}
		return $name;
    }
    
    public function fullname($format)
	{
        $format = explode('-', $format);
        $name = "";
        for ($i=0; $i < count($format); $i++) { 
            switch ($format[$i]) {
                case 'f':
                    if($i == 0)
                        $name .= $this->first_name;
                    elseif($i == 1)
                        $name .= $this->first_name;
                    break;
                case 'm':
                    if($i == 1){
                        $name .= ' '.$this->middle_name[0].'. ';
                    }else{
                        $name .= ' '.$this->middle_name[0].'. ';
                    }
                    break;
                case 'M':
                    if($i == 1){
                        $name .= ' '.$this->middle_name.' ';
                    }elseif($i == 2){
                        $name .= ' '.$this->middle_name;
                    }
                    break;
                case 'l':
                    if($i == 0){
                        $name .= $this->last_name.', ';
                    }elseif($i == 2){
                        $name .= ' '.$this->last_name;
                    }
                    break;
                
                default:
                $name = $this->first_name.' '.
                    (is_null($this->middle_name) ? '' : $this->middle_name[0].'. ').
                    $this->last_name;
                    break;
            }
        }
		
		return $name;
    }
}
