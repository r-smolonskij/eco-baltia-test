<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            "id"=>$this->id,
            "title"=>$this->title,
            "description"=>$this->description,
            "date_of_issue"=>$this->date_of_issue,
            "orders_in_last_30_days"=>$this->orders_in_last_30_days,
            "authors"=>$this->authors,
        ];
    }
}
