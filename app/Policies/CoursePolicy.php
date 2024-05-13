<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Services\Users\UserService;

class CoursePolicy
{
    use HandlesAuthorization;

    protected $userService;
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function before(User $user, $ability)
    {
        if ($user->role == 'admin') {
            return true;
        }
    }
      /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $this->userService->hasPermission('courses.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function view(User $user, Course $course)
    {
        if ($this->userService->getInstructorId($course->id) != $user->id) {
            return Response::deny('You are not the course instructor!');
        }
        return $this->userService->hasPermission('courses.view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function studentView(User $user, Course $course)
    {
        if ($this->userService->getStudentId($course->id) != $user->id) {
            return Response::deny('Enroll to show this course !');
        }
        return $this->userService->hasPermission('courses.getStudent');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->userService->hasPermission('courses.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function update(User $user, Course $course)
    {
        if ($this->userService->getInstructorId($course->id) != $user->id) {
            return Response::deny('You are not the course instructor!');
        }
        return $this->userService->hasPermission('courses.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function delete(User $user, Course $course)
    {
        if ($this->userService->getInstructorId($course->id) != $user->id) {
            return Response::deny('You are not the course instructor!');
        }
        return $this->userService->hasPermission('courses.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function restore(User $user, Course $course)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function forceDelete(User $user, Course $course)
    {
        //
    }
}
