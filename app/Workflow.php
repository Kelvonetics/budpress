<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    //
    protected $fillable = ['name', 'created_by'];

    public function Flow()
    {
        return $this->hasMany('App\Flow', 'workflow_id');
    }
}
