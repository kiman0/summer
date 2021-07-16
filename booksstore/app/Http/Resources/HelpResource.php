<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HelpResource extends JsonResource
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
            'id'=>$this->id,
            'book_name'=>$this->book_name,
            'book_author'=>$this->book_author,
            'book_price'=>$this->book_price,
            'category'=>$this->category,
            'description'=>$this->description,
            'data_img'=>$this->data_img,
        ];
    }
}
