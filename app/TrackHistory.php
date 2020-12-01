<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackHistory extends Model
{
    //
    protected $table='track_histories';
    protected $fillable = ['history_name', 'action_name_id', 'action', 'created_by'];
}
