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

 /**
 * @OA\Get(
 *     path="/api/admin/categories",
 *     tags={"Categories"},
 *     security={{"bearerToken":{}}},
 *     description="Get all categories",
 *     summary="Get all categories",
 *     @OA\RequestBody(),
 *     @OA\Response(
 *          response=200,
 *          description="Success of operation",
 *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CategoryResource"))
 *     )
 * )
 */
    public function index(Request $request)
    {
        return response()->json(
            CategoryResource::collection(
                $this->categoryService->getCategories()
            )
        );
    }

    /**
     * @OA\Post(
     *      path="/api/admin/categories",
     *      tags={"Categories"},
     *      security={{"bearerToken":{}}},
     *      summary="And new cateory",
     *      description="Add new category",
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/CategoryStoreRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success of operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="string", description="category id")
     *          )
     *      )
     * )
     */

    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();
        $category = $this->categoryService->store($data);
        return response()->json([
            'id' => $category->id
        ], 201);
    }

    /**
    * @OA\Put(
    *      path="/api/admin/categories/{id}",
    *      tags={"Categories"},
    *      security={{"bearerToken":{}}},
    *      summary="Update cateogry",
    *      description="Update category",
    *      @OA\Parameter(
    *          name="id",
    *          description="category id",
    *          in="path",
    *          required=true,
    *          @OA\Schema(
    *              type="number"
    *          ),
    *      ),
    *      @OA\RequestBody(
    *         @OA\JsonContent(ref="#/components/schemas/CategoryUpdateRequest")
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Success of operation",
    *          @OA\JsonContent()
    *      )
    * )
    */

    public function update(CategoryUpdateRequest $request, int $id)
    {
        $this->validateId($id);
        $data = $request->validated();
        $this->categoryService->update($data, $id);
        return response()->json([]);
    }

         /**
     * @OA\Delete(
     *      path="/api/admin/categories/{id}",
     *      tags={"Categories"},
     *      security={{"bearerToken":{}}},
     *      summary="Delete category",
     *      description="Delete category",
     *      @OA\Parameter(
     *          name="id",
     *          description="category id",
     *          in="path",
     *          @OA\Schema(
     *              type="number"
     *          ),
     *      ),
     *      @OA\RequestBody(
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Success of operation",
     *          @OA\JsonContent()
     *      )
     * )
     *
     */

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
