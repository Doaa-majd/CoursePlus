<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\Categories\CategoryService;
use App\Http\Requests\Web\Categories\CategoryStoreRequest;
use App\Http\Requests\Web\Categories\CategoryUpdateRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $this->authorize('viewAny', Category::class);
        $categories = $this->categoryService->index();
        return view('admin.categories.index')->with('categories', $categories);
    }

    public function show(Category $category)
    {
        $this->authorize('view', $category);
        return $category;
    }

    public function create()
    {
        $this->authorize('create', Category::class);
        return view('admin.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $this->authorize('create', Category::class);

        $data = $request->validated();
        $category = $this->categoryService->store($data);
        return redirect()
        ->route('admin.categories.index')
        ->with('alert.success', "Category \"{$category->name}\" created");
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $this->authorize('update', $category);
       // $this->checkRequest($request, $category->id);
        $data = $request->validated();
        $this->categoryService->update($data, $category->id);
        return redirect()
        ->route('admin.categories.index')
        ->with('alert.success', "Category \"{$category->name}\" updated");
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        return redirect()
        ->route('admin.categories.index')
        ->with('alert.success', "Category \"{$category->name}\" deleted");
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $table = $request->table;
        DB::table($table)->whereIn('id', explode(",", $ids))->delete();
        return response()->json(['success' => "Products Deleted successfully."]);
    }
}
