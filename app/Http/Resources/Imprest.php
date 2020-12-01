<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Imprest extends JsonResource
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
            'workflow_id' => $this->workflow_id,
            'budget_id' => $this->budget_id,
            'type_id' => $this->type_id,
            'department_id' => $this->department_id,
            'amount' => $this->amount,
            'year' => $this->year,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'balance' => $this->balance,
            'status_id' => $this->status_id,
            'flow_stage_id' => $this->flow_stage_id,
            'actions' => $this->actions,
            'budget' => $this->budget,
            'workflow' => $this->workflow,
            'department' => $this->department,
            'action' => $this->action
        ];
    }
}
