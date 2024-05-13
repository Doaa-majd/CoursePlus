<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Home\DashboardService;
use App\Models\User;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $userRole = \Auth::user()->role;
        if ($userRole == User::ADMIN) {
            return view('admin.dashboard')->with($this->dashboardService->getAdmindashboard());
        } elseif ($userRole == User::INSTRUCTOR) {
            return view('users.dashboard')->with($this->dashboardService->getInstructordashboard());
        }
    }
}
