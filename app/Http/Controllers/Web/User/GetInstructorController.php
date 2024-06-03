<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetInstructorController extends Controller
{
    public function create()
    {
        return view('users.getInstructor');
    }
}
