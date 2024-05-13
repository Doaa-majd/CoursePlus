<?php

declare(strict_types=1);

namespace App\Services\Home;

use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\CourseUser;
use Illuminate\Support\Arr;

class DashboardService
{

    public function getDashboard()
    {
        $userRole = \Auth::user()->role;
        if ($userRole == User::ADMIN) {
            return $this->getAdmindashboard();
        } elseif ($userRole == User::INSTRUCTOR) {
            return $this->getInstructordashboard();
        }
    }

    public function getAdmindashboard()
    {
        $courses = Course::count();
        $users = User::count();
        $categories = Category::count();
        $sales = Order::count();
        return [
            'courses' => $courses,
            'users' => $users,
            'categories' => $categories,
            'sales' => $sales
        ];
    }

    public function getInstructordashboard()
    {
        $userId = \Auth::id();
        $courses = CourseUser::where('user_id', $userId)->where('user_status', User::INSTRUCTOR)->count();
        return [
            'courses' => $courses,
            'sales' => $this->getInstructorSales($userId)
        ];
    }

    public function getInstructorSales($userId)
    {
        $result = \DB::table('course_orders')->select(\DB::raw('count(order_id) as total'))
                  ->wherein('course_id', function ($query) use ($userId) {
                        $query->selectRaw('course_id')
                        ->from('course_users')
                        ->where('user_id', $userId)
                        ->where('user_status', User::INSTRUCTOR);
                  })->get();
        return Arr::first($result)->total;
    }
}
