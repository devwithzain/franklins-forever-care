<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Models\User;
use App\Models\BookService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientHomePageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $clients = User::where('role', 'client')->orWhere('role', 'user')->count();
        $pending_requests = BookService::where('status', 'pending')->count();
        $total_requests = BookService::count();
        $recent_activities = BookService::latest()->take(5)->get();

        return view('client.container.home.dashboard', [
            'title' => 'Employee Dashboard - Franklin\'s Forever Care',
            'user' => $user,
            'clients' => $clients,
            'pending_requests' => $pending_requests,
            'total_requests' => $total_requests,
            'recent_activities' => $recent_activities,
        ]);
    }
}
