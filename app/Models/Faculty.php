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
        'suffix',
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
    
    /** 
     * $format = 'f-m-l'
     * $format = 'l-f-m'
     * $format = 'l-f-M'
     */
    public function fullname($format)
	{
        $format = explode('-', $format);
        $name = "";
        $trashedBadge = "";
        for ($i=0; $i < count($format); $i++) { 
            switch ($format[$i]) {
                case 'f':
                    if($i == 0)
                        $name .= $this->first_name;
                    elseif($i == 1)
                        $name .= $this->first_name;
                    break;
                case 'm':
                    if(!is_null($this->middle_name)){
                        if($i == 1){
                            $name .= ' '.$this->middle_name[0].'. ';
                        }else{
                            $name .= ' '.$this->middle_name[0].'. ';
                        }
                    }
                    break;
                case 'M':
                    if(!is_null($this->middle_name) || $this->middle_name==''){
                        if($i == 1){
                            $name .= ' '.$this->middle_name[0].'. ';
                        }else{
                            $name .= ' '.$this->middle_name[0].'. ';
                        }
                    }
                    break;
                case 'l':
                    if($i == 0){
                        $name .= $this->last_name.', ';
                    }elseif($i == 2){
                        $name .= ' '.$this->last_name;
                    }
                    break;
                case 's':
                    // if($i == 3){
                        $name .= $this->suffix;
                    // }
                    break;
                
                default:
                $name = $this->first_name.' '.
                ((is_null($this->middle_name) || $this->middle_name=='')  ? '' : $this->middle_name[0].'. ').
                    $this->last_name.
				    (is_null($this->suffix) || $this->suffix == '' ? '' : ', '.$this->suffix);
                    break;
            }
        }

        if($this->trashed()){
            $trashedBadge .= ' <span class="badge badge-danger">Deleted</span>';
        }
		
		return $name.$trashedBadge;
    }

    public function avatar()
    {
        $avatar = 'images/'.$this->gender.'.jpg';
        if(!is_null($this->image)){
            $avatar = 'images/faculty/'.$this->image;
        }
        return $avatar;
    }
}
