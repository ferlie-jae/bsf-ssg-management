<?php

namespace App\Models\Configuration\RolePermission;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
	// use SoftDeletes;
	public $timestamps = false;
	protected $table = 'model_has_roles';

	protected $fillable = [
		'role_id',
		'model_type',
		'model_id',
	];

	public function role()
	{
		return $this->belongsTo('App\Models\Configuration\RolePermission\Role', 'role_id');
	}
}
