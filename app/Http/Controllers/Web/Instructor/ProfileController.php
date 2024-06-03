<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Services\Profiles\ProfileService;
use App\Http\Requests\Web\Instructors\ProfileUpdateRequest;
use App\Http\Requests\Web\Instructors\ProfileDeleteRequest;
use App\Services\Courses\CourseService;

class ProfileController extends Controller
{
    protected $profileService;
    protected $courseService;

    public function __construct(ProfileService $profileService, CourseService $courseService)
    {
        $this->profileService = $profileService;
        $this->courseService = $courseService;
    }

    public function index()
    {
        $profile = \Auth::user()->profile;
        return view('instructor.profile.index', [
            'profile' => $profile,
            'courses' => $this->courseService->getInstructorCourses(\Auth::id())
        ]);
    }

    public function show($id)
    {
        return view('instructor.profile.showAs', [
            'profile' => $this->profileService->getInstructorProfile($id),
            'courses' => $this->courseService->getInstructorCourses(\Auth::id())
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->validated();
        $this->profileService->update($data);
        return response()->json(['success' => 'updated successfully']);
    }

    public function destroy(ProfileDeleteRequest $request)
    {
        $data = $request->validated();
        $this->profileService->delete($data);
        return response()->json(['success' => 'deleted successfully']);
    }
}
