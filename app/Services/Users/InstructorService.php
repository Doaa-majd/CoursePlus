<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Models\User;
use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\Permissions\PermissionService;

class InstructorService
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function store($data)
    {
        $id = Auth::id();

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->role = User::INSTRUCTOR ;
            $user->save();

            $this->permissionService->giveInstructorPermissions($id);
            Profile::updateOrCreate([
                'user_id' => $id,
            ], [
                'fname' => $data['fname'],
                'lname' => $data['lname'],
                'bio' => $data['bio'],
                'interests' => $data['interests'],
                'level' => $data['level'],
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
