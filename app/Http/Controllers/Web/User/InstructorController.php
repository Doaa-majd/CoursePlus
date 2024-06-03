<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\web\Users\instructorStoreRequest;
use App\Services\Users\InstructorService;

class InstructorController extends Controller
{
    protected $instructorService;

    public function __construct(InstructorService $instructorService)
    {
        $this->instructorService = $instructorService;
    }

    public function create()
    {
        return view('users.instructorCreate');
    }

    public function store(instructorStoreRequest $request)
    {
        $data = $request->validated();
        $this->instructorService->store($data);
        return \Redirect::route('instructor.courses.index');
    }
}
