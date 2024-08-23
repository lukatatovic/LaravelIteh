<?php

namespace App\Http\Resources\Expense;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'expense';

    public function toArray($request)
    {
        return [
            'voyage' => $this->resource->voyage->destination,
            'expense' => $this->resource->description,
            'cost' => $this->resource->cost,
            'provided by' => $this->resource->friend->name,
            'on' => $this->resource->date
        ];
    }
}
