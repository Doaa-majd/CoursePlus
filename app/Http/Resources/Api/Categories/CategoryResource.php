<?php

namespace App\Http\Resources\Api\Categories;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 *  @OA\Schema(
 *     title="CategoryResource",
 *     schema="CategoryResource",
 *     description="CategoryResource",
 *     @OA\Property(property="id", ref="#/components/schemas/Category/properties/id"),
 *     @OA\Property(property="name", ref="#/components/schemas/Category/properties/name"),
 *     @OA\Property(property="sub_categories", type="array", @OA\Items(
 *              @OA\Property(property="id", ref="#/components/schemas/Category/properties/id"),
 *              @OA\Property(property="name", ref="#/components/schemas/Category/properties/name")
 *          ),
 *     ),
 *     @OA\Property(property="created_at", ref="#/components/schemas/Category/properties/created_at"),
 *     @OA\Property(property="updated_at", ref="#/components/schemas/Category/properties/updated_at"),
 * )
 */

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
            "sub_categories" => $this->getSubCategories($this->resource->children),
            "created_at" => $this->resource->created_at,
            "updated_at" => $this->resource->updated_at,
        ];
    }

    protected function getSubCategories($subCategories): array
    {
        $result = [];
        foreach ($subCategories as $subCategory) {
            $result[] = [
                'id' => $subCategory['id'],
                'name' => $subCategory['name'],
                'sub_categories' => $this->getSubCategories($subCategory['children'])
            ];
        }
        return $result;
    }
}
