<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Expense extends JsonResource
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
            'purpose' => $this->purpose,
            'workflow_id' => $this->workflow_id,
            'imprest_id' => $this->imprest_id,
            'type_id' => $this->type_id,
            'amount' => $this->amount,
            'propose_date' => $this->propose_date,
            'year' => $this->year,
            'status_id' => $this->status_id,
            'flow_stage_id' => $this->flow_stage_id,
            'imprest' => $this->imprest,
            'action' => $this->action
        ];
    }
}
