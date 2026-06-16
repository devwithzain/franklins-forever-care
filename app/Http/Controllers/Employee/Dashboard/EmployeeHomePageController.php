<?php

namespace App\Http\Controllers\Employee\Dashboard;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class EmployeeHomePageController extends Controller
{
    protected NotificationService $notificationService;
    
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $user = Auth::user();
        $employeeRecord = \App\Models\Employee::where('user_id', $user->id)->first();
        $application = \App\Models\CareerApplication::where('user_id', $user->id)->latest()->first();

        // Get notifications
        $notificationCounts = $this->notificationService->getUnreadCount($user);
        $recentNotifications = $this->notificationService->getRecentUnread($user, 5);

        // FIX 1: Removed auto check-in. Just fetch today's attendance if it exists.
        $todayAttendance = null;
        if ($employeeRecord) {
            $today = \Carbon\Carbon::today();
            $todayAttendance = \App\Models\Attendance::where('employee_id', $employeeRecord->id)
                ->whereDate('check_in', $today->toDateString())
                ->first();
        }

        // Fetch weekly logs with detailed information
        $weeklyAttendance = [];
        if ($employeeRecord) {
            $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
            $endOfWeek = \Carbon\Carbon::now()->endOfWeek();

            $weeklyLogs = \App\Models\Attendance::where('employee_id', $employeeRecord->id)
                ->whereBetween('check_in', [$startOfWeek, $endOfWeek])
                ->get()
                ->keyBy(function ($item) {
                    return \Carbon\Carbon::parse($item->check_in)->format('N');
                });

            $dayNames = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
            $currentDayOfWeek = \Carbon\Carbon::now()->dayOfWeekIso;

            for ($i = 1; $i <= 7; $i++) {
                $dayName = $dayNames[$i - 1];
                if (isset($weeklyLogs[$i])) {
                    $log = $weeklyLogs[$i];
                    $checkInTime = \Carbon\Carbon::parse($log->check_in);
                    $checkOutTime = $log->check_out ? \Carbon\Carbon::parse($log->check_out) : null;
                    $duration = $checkOutTime
                        ? $checkOutTime->diffInMinutes($checkInTime)
                        : null;
                    $weeklyAttendance[] = [
                        'day' => $dayName,
                        'status' => $log->status,
                        'check_in_time' => $checkInTime->format('h:i A'),
                        'check_out_time' => $checkOutTime ? $checkOutTime->format('h:i A') : '-',
                        'duration' => $duration ? $this->formatDuration($duration) : '-',
                        'note' => $log->note,
                    ];
                } else {
                    if ($i < $currentDayOfWeek) {
                        $weeklyAttendance[] = [
                            'day' => $dayName,
                            'status' => 'Absent',
                            'check_in_time' => '-',
                            'check_out_time' => '-',
                            'duration' => '-',
                            'note' => '',
                        ];
                    } else {
                        $weeklyAttendance[] = [
                            'day' => $dayName,
                            'status' => 'OFF',
                            'check_in_time' => '-',
                            'check_out_time' => '-',
                            'duration' => '-',
                            'note' => '',
                        ];
                    }
                }
            }
        } else {
            foreach (['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'] as $dayName) {
                $weeklyAttendance[] = [
                    'day' => $dayName,
                    'status' => 'OFF',
                    'check_in_time' => '-',
                    'check_out_time' => '-',
                    'duration' => '-',
                    'note' => '',
                ];
            }
        }

        // Fetch recent requests/activity from assigned clients
        $recentActivity = [];
        if ($employeeRecord) {
            $recentActivity = \App\Models\ClientRequest::whereHas('client', function ($q) use ($user) {
                $q->where('agent_id', $user->id);
            })
                ->with('client.user')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'client_name' => $item->client?->user?->name ?? 'Unknown Client',
                        'request_type' => $item->type,
                        'status' => $item->status,
                        'description' => $item->description ?? 'No description',
                        'created_at' => $item->created_at->diffForHumans(),
                        'created_date' => $item->created_at->format('M d, Y'),
                        'created_time' => $item->created_at->format('H:i'),
                        'image' => $item->client?->user?->image ?? null,
                    ];
                });
        }

        $stats = [
            'total_clients' => \App\Models\Client::where('agent_id', $user->id)->count(),
            'total_requests' => \App\Models\ClientRequest::whereHas('client', function ($q) use ($user) {
                $q->where('agent_id', $user->id);
            })->count(),
            'active_cases' => \App\Models\Client::where('agent_id', $user->id)->where('status', 'Active')->count(),
        ];

        return view('employee.container.home.dashboard', [
            'title' => 'Employee Dashboard - Franklin\'s Forever Care',
            'user' => $user,
            'employeeRecord' => $employeeRecord,
            'application' => $application,
            'stats' => $stats,
            'weeklyAttendance' => $weeklyAttendance,
            'recentActivity' => $recentActivity,
            'todayAttendance' => $todayAttendance,
            'currentDateTime' => \Carbon\Carbon::now(),
            'notificationCounts' => $notificationCounts,
            'recentNotifications' => $recentNotifications,
        ]);
    }

    private function formatDuration($minutes)
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;

        if ($hours > 0) {
            return "{$hours}h {$mins}m";
        }
        return "{$mins}m";
    }

    public function clients()
    {
        $user = Auth::user();
        $clients = \App\Models\Client::with(['user.serviceBookings'])->where('agent_id', $user->id)->latest()->paginate(10);

        $stats = [
            'total' => \App\Models\Client::where('agent_id', $user->id)->count(),
            'active_plans' => \App\Models\Client::where('agent_id', $user->id)->where('status', 'Active')->count(),
            'critical_cases' => \App\Models\Client::where('agent_id', $user->id)->where('status', 'Critical')->count(),
        ];

        return view('employee.container.clients.index', compact('clients', 'stats'));
    }

    public function attendance()
    {
        $user = Auth::user();
        $employeeRecord = \App\Models\Employee::where('user_id', $user->id)->first();

        if (!$employeeRecord) {
            return view('employee.container.attendance.index', [
                'presentToday' => 0,
                'lateToday' => 0,
                'absentToday' => 1,
                'onLeaveCount' => 0,
                'attendances' => collect(),
                'attendanceToday' => null,
                'monthlyAttendance' => [],
                'currentMonth' => \Carbon\Carbon::now(),
                'employeeRecord' => null,
            ]);
        }

        $today = \Carbon\Carbon::today();
        $attendanceToday = \App\Models\Attendance::where('employee_id', $employeeRecord->id)
            ->whereDate('check_in', $today)
            ->first();

        $presentToday = $attendanceToday ? 1 : 0;
        $lateToday = 0;
        if ($attendanceToday) {
            $checkIn = \Carbon\Carbon::parse($attendanceToday->check_in);
            $lateThreshold = \Carbon\Carbon::today()->setTime(9, 15);
            $lateToday = $checkIn->greaterThan($lateThreshold) ? 1 : 0;
        }

        $onLeaveCount = \App\Models\Attendance::where('employee_id', $employeeRecord->id)
            ->where('status', 'On Leave')
            ->whereMonth('check_in', \Carbon\Carbon::now()->month)
            ->count();

        $absentToday = $presentToday ? 0 : 1;

        $attendances = \App\Models\Attendance::where('employee_id', $employeeRecord->id)
            ->whereBetween('check_in', [\Carbon\Carbon::now()->startOfMonth(), \Carbon\Carbon::now()->endOfMonth()])
            ->orderBy('check_in', 'desc')
            ->get();

        // Generate monthly attendance calendar
        $currentMonth = \Carbon\Carbon::now();
        $monthlyAttendance = [];
        $daysInMonth = $currentMonth->daysInMonth;
        $attendanceByDate = $attendances->keyBy(function ($item) {
            return \Carbon\Carbon::parse($item->check_in)->toDateString();
        });

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $currentMonth->copy()->day($day);
            $dateStr = $date->toDateString();
            $isWeekend = $date->isWeekend();
            $attendance = $attendanceByDate->get($dateStr);
            $isFuture = $date->isFuture(); // FIX 2: detect future dates

            if ($isWeekend) {
                $status = 'OFF';
            } elseif ($attendance) {
                $status = $attendance->status;
            } elseif ($isFuture || $date->isToday() && !$attendance) {
                // FIX 2: future days and today (if no check-in yet) show as blank/upcoming, not Absent
                $status = 'Upcoming';
            } else {
                // Only past weekdays with no record are truly Absent
                $status = 'Absent';
            }

            $monthlyAttendance[] = [
                'day' => $day,
                'date' => $date,
                'isWeekend' => $isWeekend,
                'isFuture' => $isFuture,
                'status' => $status,
                'attendance' => $attendance,
                'isToday' => $date->isToday(),
            ];
        }

        return view('employee.container.attendance.index', compact(
            'presentToday',
            'lateToday',
            'absentToday',
            'onLeaveCount',
            'attendances',
            'attendanceToday',
            'monthlyAttendance',
            'currentMonth',
            'employeeRecord'
        ));
    }

    public function checkIn()
    {
        $user = Auth::user();
        $employeeRecord = \App\Models\Employee::where('user_id', $user->id)->first();

        if (!$employeeRecord) {
            return redirect()->back()->with('error', 'Employee record not found.');
        }

        $today = \Carbon\Carbon::today();
        $exists = \App\Models\Attendance::where('employee_id', $employeeRecord->id)
            ->whereDate('check_in', $today->toDateString())
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You have already checked in today.');
        }

        $checkIn = now();
        $lateThreshold = \Carbon\Carbon::today()->setTime(9, 15);
        $status = $checkIn->greaterThan($lateThreshold) ? 'Late' : 'Present';

        \App\Models\Attendance::create([
            'employee_id' => $employeeRecord->id,
            'check_in' => $checkIn,
            'status' => $status,
            'note' => 'Manual check-in'
        ]);

        return redirect()->back()->with('success', 'Checked in successfully at ' . $checkIn->format('h:i A'));
    }

    public function checkOut()
    {
        $user = Auth::user();
        $employeeRecord = \App\Models\Employee::where('user_id', $user->id)->first();

        if (!$employeeRecord) {
            return redirect()->back()->with('error', 'Employee record not found.');
        }

        $today = \Carbon\Carbon::today();
        $attendance = \App\Models\Attendance::where('employee_id', $employeeRecord->id)
            ->whereDate('check_in', $today->toDateString())
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'You need to check in first.');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'You have already checked out today.');
        }

        $attendance->update([
            'check_out' => now()
        ]);

        return redirect()->back()->with('success', 'Checked out successfully at ' . now()->format('h:i A'));
    }

    public function outdoor()
    {
        return view('employee.container.outdoor.index');
    }

    public function requests(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $query = \App\Models\ClientRequest::with(['client.user'])
            ->whereHas('client', function ($q) use ($user) {
                $q->where('agent_id', $user->id);
            })
            ->latest();

        $activeTab = $request->query('tab', 'all');
        if ($activeTab !== 'all') {
            $query->where('type', $activeTab);
        }
        $requests = $query->paginate(10)->appends(['tab' => $activeTab]);

        $stats = [
            'total' => \App\Models\ClientRequest::whereHas('client', function ($q) use ($user) {
                $q->where('agent_id', $user->id);
            })->count(),
            'change_agent' => \App\Models\ClientRequest::where('type', 'Change Agent')->whereHas('client', function ($q) use ($user) {
                $q->where('agent_id', $user->id);
            })->count(),
        ];

        return view('employee.container.requests.index', compact('requests', 'stats', 'activeTab'));
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $this->notificationService->getAllForUser($user);
        $notificationCounts = $this->notificationService->getUnreadCount($user);
        $broadcasts = \App\Models\Broadcast::with('sender')->latest()->paginate(10);
        return view('employee.container.notifications.index', compact('notifications', 'notificationCounts', 'broadcasts'));
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        $this->notificationService->markAsRead($user, $id);
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $this->notificationService->markAllAsRead($user);
        return redirect()->back()->with('success', 'All notifications marked as read.');
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

    public function updateRequestStatus(\Illuminate\Http\Request $request, \App\Models\ClientRequest $clientRequest)
    {
        $user = Auth::user();

        if ($clientRequest->client->agent_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $allowedTypes = ['General Support', 'Outdoor Access'];
        if (!in_array($clientRequest->type, $allowedTypes)) {
            return redirect()->back()->with('error', 'Only administrative staff can update status for ' . $clientRequest->type . ' requests.');
        }

        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $clientRequest->update([
            'status' => $request->status,
        ]);

        return redirect()->route('employee.requests.index')->with('success', 'Request status updated successfully!');
    }
}