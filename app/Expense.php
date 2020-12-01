<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    //

    public function imprest()
    {
        return $this->belongsTo('App\Imprest', 'imprest_id');
    }
    
    public function action()
    {
        return $this->belongsTo('App\Action', 'flow_stage_id');
    }
}
