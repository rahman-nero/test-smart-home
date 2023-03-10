<?php

namespace App\Http\Resources\Api\Equipment;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EquipmentResource extends ResourceCollection
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
        return $this->collection;
    }
}
