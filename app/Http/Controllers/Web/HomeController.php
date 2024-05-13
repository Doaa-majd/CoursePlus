<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Home\HomeService;
use App\Services\Courses\CourseService;
use App\Services\Categories\CategoryService;

class HomeController extends Controller
{
    protected $homeService;
    protected $courseService;
    protected $categoryService;

    public function __construct(
        HomeService $homeService,
        CourseService $courseService,
        CategoryService $categoryService
    ) {
        $this->homeService = $homeService;
        $this->courseService = $courseService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        return view('index', [
            'settings' => $this->homeService->getHomeSettings(),
            'courses' => $this->courseService->getCourses(),
            'categories' => $this->categoryService->getCategories()
        ]);
    }
}
