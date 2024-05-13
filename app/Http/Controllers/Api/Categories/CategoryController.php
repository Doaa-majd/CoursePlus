<?php

namespace App\Http\Controllers\Api\Categories;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Categories\CategoryService;
use App\Http\Resources\Api\Categories\CategoryResource;
use App\Http\Requests\Api\Categories\CategoryStoreRequest;
use App\Http\Requests\Api\Categories\CategoryUpdateRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        return response()->json(
            CategoryResource::collection(
                $this->categoryService->getCategories()
            )
        );
    }

    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();
        $category = $this->categoryService->store($data);
        return response()->json([
            'id' => $category->id
        ], 201);
    }

    public function update(CategoryUpdateRequest $request, int $id)
    {
        $this->validateId($id);
        $data = $request->validated();
        $this->categoryService->update($data, $id);
        return response()->json([]);
    }

    public function destroy(int $id)
    {
        $this->validateId($id);
        $this->categoryService->delete($id);
        return response()->json([], 204);
    }

    public function validateId($id)
    {
        Validator::validate([
            'id' => $id
        ], [
            'id' => 'required|numeric|exists:categories,id'
        ]);
    }
}
