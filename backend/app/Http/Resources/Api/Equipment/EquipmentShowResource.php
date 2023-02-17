<?php

namespace App\Http\Resources\Api\Equipment;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentShowResource extends JsonResource
{
    public static $wrap = 'message';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'serial_number' => $this->serial_number,
            'type' => $this->type->title,
            'type_id' => $this->type->id,
            'comment' => $this->comment,
        ];

    }
}
