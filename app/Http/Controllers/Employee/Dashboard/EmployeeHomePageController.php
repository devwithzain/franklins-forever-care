<?php

namespace App\Http\Controllers\Employee\Dashboard;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmployeeHomePageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $clients = User::where('role', 'client')->orWhere('role', 'user')->count();

        return view('employee.container.home.dashboard', [
            'title' => 'Employee Dashboard - Franklin\'s Forever Care',
            'user' => $user,
            'clients' => $clients,
        ]);
    }
}
