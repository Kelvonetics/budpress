<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return
        [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
            'department_id' => $this->department_id,
            'phone' => $this->phone,
            'address' => $this->address,
            'dob' => $this->dob,
            'doj' => $this->doj,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'state_id' => $this->state_id,
            'nationality' => $this->nationality,
            'photo' => $this->photo,
            'state' => $this->state,
            'department' => $this->department
        ];
    }
}
