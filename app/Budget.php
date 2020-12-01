<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    //
    // protected $fillable = ['name', 'description', 'type_id', 'department_id', 'amount', 'end_date', 'balance', 'workflow_id'];

    public function workflow()
    {
        return $this->belongsTo('App\Workflow', 'workflow_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }
    
    public function action()
    {
        return $this->belongsTo('App\Action', 'flow_stage_id');
    }
    
    public function Imprest()
    {
        return $this->hasMany('App\Imprest', 'budget_id');
    }
    
    
}
