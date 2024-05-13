<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Course;
use App\Models\CourseUser;
use App\Models\User;

class CourseService
{
    public const ADMIN = 'admin';
    public const INSTRUCTOR = 'instructor';

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
        if (\Auth::user()->role == self::ADMIN) {
            $courses = Course::join('categories', 'categories.id', '=', 'courses.category_id')
                ->select('courses.*', 'categories.name as category_name', 'categories.id as category_id')
                ->paginate(5);
        }

        if (\Auth::user()->role == self::INSTRUCTOR) {
            $courses = Course::with('category')->whereHas('courseUsers', function ($q) {
                $q->where('user_id', \Auth::id())
                ->where('user_status', 'instructor');
            })->paginate(5);
        }
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
        return Course::where('id', '=', $id)->with('sections.lessones.lessonable')->first();
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
}
