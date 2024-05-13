<?php

namespace App\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Courses\SectionService;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\Courses\SectionResource;
use App\Http\Requests\Api\Courses\SectionStoreRequest;
use App\Http\Requests\Api\Courses\SectionUpdateRequest;

class SectionController extends Controller
{
    protected $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    public function store(SectionStoreRequest $request)
    {
        $data = $request->validated();
        $section = $this->sectionService->store($data);
        return response()->json([
            'id' => $section->id
        ], 201);
    }

    public function update(SectionUpdateRequest $request, int $id)
    {
        $this->validateId($id);
        $data = $request->validated();
        $this->sectionService->update($data, $id);
        return response()->json([]);
    }

    public function destroy(int $id)
    {
        $this->validateId($id);
        $this->sectionService->delete($id);
        return response()->json([], 204);
    }

    public function validateId($id)
    {
        Validator::validate([
            'id' => $id
        ], [
            'id' => 'required|numeric|exists:sections,id'
        ]);
    }
}
