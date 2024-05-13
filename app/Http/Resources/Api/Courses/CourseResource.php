<?php

namespace App\Http\Resources\Api\Courses;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->resource->id,
            "category_id" => $this->resource->category_id,
            "title" => $this->resource->title,
            "sub_title" => $this->resource->sub_title,
            "image" => $this->resource->image,
            "languge" => $this->resource->languge,
            "description" => $this->resource->description,
            "price" => $this->resource->price,
            "status" => $this->resource->status,

        ];
    }
}
