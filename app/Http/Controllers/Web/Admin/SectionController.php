<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Courses\SectionStoreRequest;
use App\Http\Requests\Api\Courses\SectionUpdateRequest;
use App\Services\Courses\SectionService;
use Illuminate\Support\Facades\Validator;

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
        return response()->json(['success' => "Section Created successfully.", 'section' => $section]);
    }

    public function update(SectionUpdateRequest $request)
    {
        //$this->validateId($id);
        $data = $request->validated();
        $this->sectionService->updateSection($data);
        return response()->json([]);
    }

    public function delete(int $id)
    {
        $this->validateId($id);
        $this->sectionService->delete($id);
        return response()->json('Section Deleted');
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
