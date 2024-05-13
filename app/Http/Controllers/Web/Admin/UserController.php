<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Services\Users\UserService;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getUsers();
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();
        return response()->json('User Deleted ');
    }
}
