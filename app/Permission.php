<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $fillable=['department_id', 'name', 'constant', 'created_by'];

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    

    public function permission()
    {
    	return $this->belongsToMany('App\Role', 'permission_role', 'permission_id', 'role_id');
    }
}
