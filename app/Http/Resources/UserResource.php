<?php


namespace App\Http\Resources;



use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->resource->birth_date == null){
            $date = $this->resource->birth_date;
        } else {
            $date = $this->resource->birth_date->format('d-m-Y');
        }

        return [
            'id' => $this->resource->id,
            'username' => $this->resource->username,
            'email' => $this->resource->email,
            'last_name' => $this->resource->last_name,
            'first_name' => $this->resource->first_name,
            'second_name' => $this->resource->second_name,
            'gender' => $this->resource->gender,
            'role' => $this->resource->role,
            'birth_date' => $date,
            'organisation' => $this->resource->organisation,
            'photo' => $this->resource->photo
        ];
    }
}
