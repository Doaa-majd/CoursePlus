<?php

declare(strict_types=1);

namespace App\Services\Categories;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function getCategories(): Collection
    {
        return Category::whereNull('parent_id')->with('children')->get();
    }

    public function index(): LengthAwarePaginator
    {
        return Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select('categories.*', 'parents.name as parent_name')
            ->paginate(5);
    }

    public function store(array $data): Category
    {
        return Category::create([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'],
        ]);
    }

    public function update(array $data, int $id): void
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $data['name'],
            'parent_id' => $data['parent_id']
        ]);
    }

    public function delete(int $id): void
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}
