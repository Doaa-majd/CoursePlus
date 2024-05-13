<?php

namespace App\Http\Resources\Api\Categories;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "name" => $this->resource->name,
            "sub_categories" => $this->getSubCategories($this->resource->childrenRecursive)
        ];
    }

    protected function getSubCategories($subCategories): array
    {
        $result = [];
        foreach ($subCategories as $subCategory) {
            $result[] = [
                'id' => $subCategory['id'],
                'name' => $subCategory['name'],
                'sub_categories' => $this->getSubCategories($subCategory['childrenRecursive'])
            ];
        }
        return $result;
    }
}
