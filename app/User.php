<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table='users';
    
    protected $fillable = ['firstname', 'lastname', 'email', 'password', 'department_id', 'phone', 'address', 'dob', 'doj', 'gender', 'marital_status', 'state_id', 'nationality', 'photo', 'created_by'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];




    public function state()
    {
        return $this->belongsTo('App\State', 'state_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');        
    }

    public function ExamType()
    {
        return $this->hasMany('App\ExamType', 'user_id');
    }

    public function Flow()
    {
        return $this->hasMany('App\Flow', 'user_id');
    }

}
