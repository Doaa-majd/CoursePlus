<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use App\Services\Courses\VideoService;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\Courses\VideoStoreRequest;
use App\Http\Requests\Api\Courses\VideoUpdateRequest;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function store(VideoStoreRequest $request)
    {
        $data = $request->validated();
        $videoId = $this->videoService->storeVideo($data);
        return response()->json([
            'id' => $videoId->id
        ], 201);
    }

    public function update(VideoUpdateRequest $request, int $videoId)
    {
        $this->validateId($videoId);
        $data = $request->validated();
        $this->videoService->updateVideo($data, $videoId);
        return response()->json([]);
    }

    public function destroy(int $videoId)
    {
        $this->validateId($videoId);
        $this->videoService->delete($videoId);
        return response()->json([], 204);
    }

    public function validateId($id)
    {
        Validator::validate([
            'id' => $id
        ], [
            'id' => 'required|numeric|exists:videos,id'
        ]);
    }
}
