<?php

namespace App\Http\Resources\Voyage;

use Illuminate\Http\Resources\Json\JsonResource;

class VoyageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'voyage';

    public function toArray($request)
    {
        return [
            'destination' => $this->resource->destination,
            'arrival date' => $this->resource->arrival,
            'departure date' => $this->resource->departure,
            'mean of transportation' => $this->resource->transportation,
            'total expenses' => $this->resource->total_cost,
        ];
    }
}
