<?php

namespace App\Models\Configuration\RolePermission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
	use SoftDeletes;
	
	protected $table = 'roles';

	public function permissions()
	{
		return $this->belongsToMany('App\Models\RolePermission\RolePermission')->withTimestamps();
	}

}
