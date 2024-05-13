<?php

declare(strict_types=1);

namespace App\Services\Categories;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    public function getCategories(): Collection
    {
        return Category::whereNull('parent_id')->get();
    }

    public function store(array $data): Category
    {
        return Category::create([
            'name' => $data['name'],
            'parent_id' => $data['parent_id']
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
