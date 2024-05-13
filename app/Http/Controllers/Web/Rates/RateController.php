<?php

namespace App\Http\Controllers\Web\Rates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Courses\RatingService;
use App\Http\Requests\web\Rates\RateStoreRequest;

class RateController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function store(RateStoreRequest $request)
    {
        $data = $request->validated();
        $this->ratingService->store($data);
        return response()->json(['success' => " rating inserted successfully."]);
    }
}
