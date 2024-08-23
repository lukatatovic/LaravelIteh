<?php

namespace App\Http\Resources\Friend;

use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'friend';

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
        ];
    }
}
