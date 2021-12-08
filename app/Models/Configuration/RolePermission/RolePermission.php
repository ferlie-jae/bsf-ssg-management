<?php

namespace App\Models\Configuration\RolePermission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermission extends Model
{
	use SoftDeletes;

	protected $table = 'role_has_permissions';

	protected $fillable = [
		'permission_id',
		'model_type',
		'model_id',
	];

	public function role()
	{
		return $this->belongsTo('App\Models\Configuration\RolePermission\Role', 'role_id', 'id');
	}
}
