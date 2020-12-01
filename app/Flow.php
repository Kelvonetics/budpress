<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    //
    protected $fillable = ['workflow_id', 'name', 'action_id', 'position', 'user_role_id', 'created_by'];


    public function workflow()
    {
        return $this->belongsTo('App\Workflow', 'workflow_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_role_id');
    }

    public function action()
    {
        return $this->belongsTo('App\Action', 'action_id');
    }

}
