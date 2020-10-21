<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $departments = Department::all();
        $users = User::paginate(9);

        return view('dashboard.index')
            ->with('departments', $departments)
            ->with('users', $users);
    }
}
