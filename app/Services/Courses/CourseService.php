<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Course;
use App\Models\CourseUser;
use App\Models\User;
use App\Services\ImageService;

class CourseService
{
    public const SINGLE_SESSION_TYPE = 'single session';
    public const COMPLETE_COURSE_TYPE = 'complete course';

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function getCourses()
    {
        return Course::get();
    }

    public function store(array $data): Course
    {
        return Course::create([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'sub_title' => $data['sub_title'],
            'languge' => $data['languge'],
            'description' => $data['description'],
            'price' => $data['price'],
            'status' => $data['status']
        ]);
    }

    public function getCourseById(int $id): Course
    {
        return Course::findOrFail($id);
    }

    public function updateCourse(array $data, int $id): void
    {
        $course = Course::findOrFail($id);
        $course->update([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'sub_title' => $data['sub_title'],
            'languge' => $data['languge'],
            'description' => $data['description'],
            'price' => $data['price'],
            'status' => $data['status']
        ]);
    }

    public function delete(int $id): void
    {
        $course = Course::findOrFail($id);
        $course->delete();
    }

    // web methods
    public function getCoursesByUserType()
    {
        $courses = [];
        if (\Auth::user()->role == User::ADMIN) {
            $courses = Course::join('categories', 'categories.id', '=', 'courses.category_id')
                ->select('courses.*', 'categories.name as category_name', 'categories.id as category_id')
                ->paginate(5);
        }

        if (\Auth::user()->role == User::INSTRUCTOR) {
            $courses = Course::with('category')->whereHas('courseUsers', function ($q) {
                $q->where('user_id', \Auth::id())
                ->where('user_status', User::INSTRUCTOR);
            })->paginate(5);
        }
        return $courses;
    }

    public function getAllCourses()
    {
        $courses = [];
        $courses = Course::join('categories', 'categories.id', '=', 'courses.category_id')
                ->select('courses.*', 'categories.name as category_name', 'categories.id as category_id')
                ->paginate(5);
        return $courses;
    }

    public function getInstructorCourses($courseId)
    {
        $courses = Course::with('category')->whereHas('courseUsers', function ($q) use ($courseId) {
            $q->where('user_id', $courseId)
            ->where('user_status', User::INSTRUCTOR);
        })->paginate(10);
        return $courses;
    }

    public function storeCourse(array $data): Course
    {
        $storeAs = 'courses' . '/' . 'user-' . \Auth::id() ;
        $imageName = $data['title'] . '.' . $data['image']->extension();
        $path = $data['image']->storeAs($storeAs, $imageName, 'images');

        $data['image'] = $path;

        \DB::beginTransaction();
        try {
            $course = Course::create($data);
            CourseUser::create([
                'user_id' => \Auth::id(),
                'course_id' => $course->id,
                'user_status' => 'instructor',
            ]);
            \DB::commit();

            return $course;
        } catch (Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }
    public function update(array $data, course $course)
    {
        $storeAs = 'courses' . '/' . 'user-' . \Auth::id() ;
        $imageName = $data['title'] . '.' . $data['image']->extension();
        $path = $data['image']->storeAs($storeAs, $imageName, 'images');

        $data['image'] = $path;

        $courseImg = public_path('images') . $course->image;
        if (file_exists($courseImg)) {
            @unlink($courseImg);
        }
        $course->update($data);
    }

    public function getCourseLessons(int $id): course
    {
        return Course::where('id', $id)->with('sections.lessones.lessonable')->first();
    }

    public function getCategoryCourses(int $categoryId)
    {
        return Course::where('category_id', $categoryId)->limit(5)->get();
    }

    public function getCourseWithRelations($courseId): Course
    {
        return $course = Course::where('id', $courseId)
                    ->with('category', 'rating', 'questions', 'sections.lessones.lessonable')
                    ->with(['courseUsers' => function ($query) {
                        $query->where('user_status', User::INSTRUCTOR);
                    }])->first();
    }

    ////////instructor area

    public function processCourse($courseData)
    {
        $data = $this->getCourseDataFromSession();
        $data['image'] = $courseData['courseImg64'];
        $course = $this->storeInstructorCourse($data);
        $this->deleteCourseDataFromSession();
        return $course;
    }
    private function getCourseDataFromSession()
    {
        $data = [];
        $data['type'] = session()->get('type');
        $data['title'] = session()->get('title');
        $data['sub_title'] = session()->get('sub_title');
        $data['description'] = session()->get('description');
        $data['category_id'] = session()->get('category_id');
        $data['languge'] = session()->get('languge');
        $data['price'] = session()->get('price');
        return $data;
    }

    private function storeInstructorCourse($data)
    {
        $storeAs = 'courses' . '/' . 'user-' . \Auth::id() ;
        $imagePath = $this->imageService->uploadImage64ToDisk($data['image'], 'images', $storeAs);
        $data['image'] = $imagePath;

        \DB::beginTransaction();
        try {
            $course = Course::create($data);
            CourseUser::create([
                'user_id' => \Auth::id(),
                'course_id' => $course->id,
                'user_status' => User::INSTRUCTOR,
            ]);
            \DB::commit();

            return $course;
        } catch (Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    private function deleteCourseDataFromSession()
    {
        session()->forget(['type', 'title', 'sub_title', 'description', 'category_id', 'languge', 'price']);
    }

    public function instructorUpdateCourse($data, $course)
    {
        if (isset($data['image'])) {
            $folder = 'courses' . '/' . 'user-' . \Auth::id() ;
            $imagePath = $this->imageService->uploadImage64ToDisk($data['image'], 'images', $folder);
            $this->imageService->deleteImageFromDisk('images', $course->image);
            $course->update(['image' => $imagePath]);
            return;
        }
        $course->update($data);
    }
}
