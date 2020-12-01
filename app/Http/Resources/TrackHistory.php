<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackHistory extends JsonResource
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
            'history_name' => $this->history_name,
            'action_name_id' => $this->action_name_id,
            'action' => $this->action,
            'created_by' => $this->created_by
        ];
    }
}
