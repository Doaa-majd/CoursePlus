<?php

namespace App\Http\Controllers\Web\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Search\SearchService;
use App\Http\Requests\Web\Search\SearchIndexRequest;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index(Request $request)//SearchIndexRequest
    {
        //$data = $request->validated();
        $courses = $this->searchService->getCourses($request);
        return view('search.searchCourses', [ 'courses' => $courses]);
    }
}
