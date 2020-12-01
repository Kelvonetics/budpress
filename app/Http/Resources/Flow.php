<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Flow extends JsonResource
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
            'workflow_id' => $this->workflow_id,
            'name' => $this->name,
            'action_id' => $this->action_id,
            'position' => $this->position,
            'user_role_id' => $this->user_role_id,
            'created_by' => $this->created_by,
            'workflow' => $this->workflow,
            'user' => $this->user,
            'action' => $this->action
        ];
    }
}
