<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Budget extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'type_id' => $this->type_id,
            'department_id' => $this->department_id,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'year' => $this->year,
            'end_date' => $this->end_date,
            'workflow_id' => $this->workflow_id,
            'flow_stage_id' => $this->flow_stage_id,
            'actions' => $this->actions,
            'workflow' => $this->workflow,
            'department' => $this->department,
            'action' => $this->action
        ];
    }
}
