<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Profile;
use App\Models\CourseUser;
use App\Models\User;
use App\Services\Courses\UserCourseService;
use App\Services\Permissions\PermissionService;

class CourseEnrollService
{
    protected $userCourseService;
    protected $permissionService;

    public function __construct(
        UserCourseService $userCourseService,
        PermissionService $permissionService
    ) {
        $this->userCourseService = $userCourseService;
        $this->permissionService = $permissionService;
    }

    public function store(array $data)
    {
        $userId = \Auth::id();

        \DB::beginTransaction();
        try {
            CourseUser::create([
                'user_id' => $userId,
                'course_id' => $data['course_id'],
                'user_status' => User::STUDENT
            ]);

            $this->permissionService->giveStudenPermissions($userId);

            \DB::commit();
        } catch (Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }

}
