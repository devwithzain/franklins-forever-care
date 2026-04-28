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

    public function clients()
    {
        $clients = \App\Models\Client::with(['user', 'agent'])->where('agent_id', Auth::id())->latest()->paginate(10);
        $stats = [
            'total' => \App\Models\Client::where('agent_id', Auth::id())->count(),
            'active_plans' => \App\Models\Client::where('agent_id', Auth::id())->where('status', 'Active')->count(),
            'pending_assignment' => 0,
            'critical_cases' => \App\Models\Client::where('agent_id', Auth::id())->where('status', 'Critical')->count(),
        ];
        return view('employee.container.clients.index', compact('clients', 'stats'));
    }

    public function attendance()
    {
        return view('employee.container.attendance.index');
    }

    public function outdoor()
    {
        return view('employee.container.outdoor.index');
    }

    public function requests(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\ClientRequest::with(['client.user'])->latest();
        $activeTab = $request->query('tab', 'all');
        if ($activeTab !== 'all') {
            $query->where('type', $activeTab);
        }
        $requests = $query->paginate(10)->appends(['tab' => $activeTab]);
        
        $stats = [
            'total' => \App\Models\ClientRequest::count(),
            'change_agent' => \App\Models\ClientRequest::where('type', 'Change Agent')->count(),
            'outdoor' => \App\Models\ClientRequest::where('type', 'Outdoor Access')->count(),
            'cancellations' => \App\Models\ClientRequest::where('type', 'Cancellations')->count(),
        ];

        return view('employee.container.requests.index', compact('requests', 'stats', 'activeTab'));
    }

    public function notifications()
    {
        return view('employee.container.notifications.index');
    }

    public function setting()
    {
        $user = Auth::user();
        $sessions = \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($session) {
                return (object) [
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'user_agent' => $session->user_agent,
                    'last_activity' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                    'is_current_device' => $session->id === request()->session()->getId(),
                ];
            });

        return view('employee.container.setting.listings', [
            'user' => $user,
            'sessions' => $sessions,
            'title' => 'Settings - Franklin\'s Forever Care'
        ]);
    }

    public function updateSetting(\Illuminate\Http\Request $request, $id)
    {
        try {
            $user = \App\Models\User::findOrFail($id);
            if ($user->id !== Auth::id()) {
                abort(403);
            }
            
            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'current_password' => 'required_with:password|string|nullable',
                'password' => ['nullable', 'confirmed', 'min:8'],
                'two_factor_enabled' => 'nullable|boolean',
            ]);

            if ($request->has('name')) {
                $user->name = $validatedData['name'];
            }

            if ($request->has('email') && $request->email !== $user->email) {
                $user->email = $validatedData['email'];
            }

            $user->two_factor_enabled = $request->has('two_factor_enabled');

            if ($request->hasFile('image')) {
                $storage = \Illuminate\Support\Facades\Storage::disk('public');
                if ($user->image && $storage->exists($user->image)) {
                    $storage->delete($user->image);
                }
                $imageName = 'profile/' . \Illuminate\Support\Str::random(32) . "." . $request->image->getClientOriginalExtension();
                $storage->put($imageName, file_get_contents($request->image->getRealPath()));
                $user->image = $imageName;
            }

            if (!empty($validatedData['password'])) {
                if (!isset($validatedData['current_password']) || !\Illuminate\Support\Facades\Hash::check($validatedData['current_password'], $user->password)) {
                    return back()->withErrors(['current_password' => 'Current password is incorrect']);
                }
                $user->password = \Illuminate\Support\Facades\Hash::make($validatedData['password']);
            }

            $user->save();
            return redirect()->back()->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function logoutSession($id)
    {
        \Illuminate\Support\Facades\DB::table('sessions')->where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Session terminated successfully.');
    }
}
