<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'bookss_id'=>$this->bookss_id,
            'sessions_id'=>$this->sessions_id,
            'bookss_count'=>$this->bookss_count,
        ];
    }
}
