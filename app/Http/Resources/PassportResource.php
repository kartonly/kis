<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PassportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->resource)){
            return [
                'id' => $this->resource->id,
                'issueOrg' => $this->resource->issueOrg,
                'clientId' => $this->resource->clientId,
                'pasId' => $this->resource->pasId,
                'issueDate' => $this->resource->issueDate->format('d-m-Y'),
            ];
        }
        return [
            'error' => 'нет'
        ];
    }
}
