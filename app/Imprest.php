<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imprest extends Model
{
    //
    protected $table='imprests';


    public function budget()
    {
        return $this->belongsTo('App\Budget', 'budget_id');
    }

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
}
