<?php

declare(strict_types=1);

namespace App\Services\Permissions;

use Illuminate\Support\Facades\DB;

class PermissionService
{

    public function giveInstructorPermissions(int $id): void
    {
        // give user type instructor new permissions to create courses
        DB::table('permissions')->insertOrIgnore([
            ['user_id' => $id, 'permission' => 'courses.create'],
            ['user_id' => $id, 'permission' => 'courses.delete'],
            ['user_id' => $id, 'permission' => 'courses.edit'],
            ['user_id' => $id, 'permission' => 'courses.index'],
            ['user_id' => $id, 'permission' => 'courses.view'],
            ['user_id' => $id, 'permission' => 'courses.getStudent'],
        ]);
    }

    public function giveStudenPermissions(int $id)
    {
        DB::table('permissions')->insertOrIgnore([
            ['user_id' => $id, 'permission' => 'courses.getStudent'],
        ]);
    }
}