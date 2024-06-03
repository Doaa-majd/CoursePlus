<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Category",
 *     title="Category",
 *     description="Categories",
 *     @OA\Property(property="id", type="number", format="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="parent_id", type="number", format="integer"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="created_at", type="date"),
 *     @OA\Property(property="updated_at", type="date")
 * )
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')
            ->withDefault([
                'name' => 'No Parent'
            ]);
    }

    // If sub categories of a childrens
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}
