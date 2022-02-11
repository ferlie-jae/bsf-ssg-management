<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Announcement;
use Auth;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
	use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id_image',
        'avatar',
        'is_verified',
        'username',
        'email',
        'password',
        'temp_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
	{
		return $this->belongsTo('App\Models\Configuration\RolePermission\UserRole', 'id', 'model_id');
    }

    public function userInfo()
    {
        if(isset($this->student->id)){
            if(Auth::user()->hasrole('System Administrator')){
                return Student::withTrashed()->find($this->student->student_id);
            }else{
                return $this->student->student;
            }
        }
        if(isset($this->faculty->id)){
            if(Auth::user()->hasrole('System Administrator')){
                return Faculty::withTrashed()->find($this->faculty->faculty_id);
            }else{
                return $this->faculty->faculty;
            }
        }
        return false;
    }
    
    public function student(){
        return $this->hasOne('App\Models\UserStudent', 'user_id');
    }

    public function faculty(){
        return $this->hasOne('App\Models\UserFaculty', 'user_id');
    }

    public function isOfficer()
    {
        if(isset($this->student->id)){
            if($this->student->student->isOfficer()){
                return True;
            }
        }
        return False;
    }

    public function seen_announcements()
    {
        return $this->hasMany('App\Models\UserAnnouncement', 'user_id');
    }

    public function new_announcements()
    {
        $seen_announcements = $this->seen_announcements()->get('id');
        return Announcement::whereNotIn('id', $seen_announcements)->get();
    }

    public function schoolIDImage()
    {
        if(!is_null($this->school_id_image)){
            return 'images/user/uploads/'.$this->school_id_image;
        }
        return 'images/no-image.png';
    }

    public function avatar()
    {
        $avatar = "";
        if(is_null($this->avatar)){
            $avatar = "images/user/default/male.jpg";
        }else{
            $avatar = "images/user/avatar/".$this->avatar;
        }
        return $avatar;
    }

}
