<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexPage()
    {
        $totalUsers = User::count();
        $totalRoles = Role::count();
        return view('admin.pages.dashboard.index', compact('totalUsers', 'totalRoles'));
    }
}
