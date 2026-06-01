<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\User;
use App\Models\Client;
use App\Models\ServiceBooking;
use App\Models\Broadcast;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminHomePageController extends Controller
{
   public function index()
   {
      $stats = [
         'total_clients' => Client::count(),
         'specialists' => User::where('role', 'employee')->count(),
         'pending_requests' => \App\Models\ClientRequest::where('status', 'Pending')->count(),
         'pending_applications' => \App\Models\CareerApplication::where('status', 'pending')->count(),
         'monthly_revenue' => ServiceBooking::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('amount'),
         'active_duty' => ServiceBooking::where('payment_status', 'paid')->count(),
      ];

      // Growth calculation (comparing this month to last month)
      $lastMonthClients = Client::whereMonth('created_at', now()->subMonth()->month)->count();
      $stats['client_growth'] = $lastMonthClients > 0
         ? round((($stats['total_clients'] - $lastMonthClients) / $lastMonthClients) * 100)
         : 100;

      $recentActivities = ServiceBooking::with('service')
         ->latest()
         ->take(5)
         ->get();

      return view('admin.container.home.dashboard', [
         'title' => "Admin Dashboard – Franklin's Forever Care",
         'stats' => $stats,
         'recentActivities' => $recentActivities,
      ]);
   }

   public function employees()
   {
      return view('admin.container.employees.index');
   }

   public function attendance()
   {
      $attendances = \App\Models\Attendance::with('employee.user')->latest()->paginate(10);
      $stats = [
         'present' => \App\Models\Attendance::whereDate('check_in', now()->toDateString())->where('status', 'Present')->count(),
         'late' => \App\Models\Attendance::whereDate('check_in', now()->toDateString())->where('status', 'Late')->count(),
         'absent' => \App\Models\Attendance::whereDate('check_in', now()->toDateString())->where('status', 'Absent')->count(),
         'on_leave' => \App\Models\Attendance::whereDate('check_in', now()->toDateString())->where('status', 'On Leave')->count(),
      ];
      return view('admin.container.attendance.index', compact('attendances', 'stats'));
   }

   public function payments()
   {
      $bookings = ServiceBooking::with(['user', 'service'])->latest()->paginate(10);
      $stats = [
         'total_billed' => ServiceBooking::sum('amount'),
         'collected' => ServiceBooking::where('payment_status', 'paid')->sum('amount'),
         'outstanding' => ServiceBooking::where('payment_status', 'unpaid')->sum('amount'),
         'overdue' => ServiceBooking::where('payment_status', 'unpaid')->where('created_at', '<', now()->subDays(30))->sum('amount'),
      ];
      return view('admin.container.payments.index', compact('bookings', 'stats'));
   }

   public function outdoor()
   {
      $sessions = \App\Models\OutdoorActivity::with(['employee.user', 'client.user'])->latest()->paginate(10);
      $stats = [
         'active' => \App\Models\OutdoorActivity::where('status', 'Active')->count(),
         'total_today' => \App\Models\OutdoorActivity::whereDate('created_at', now()->toDateString())->count(),
      ];
      return view('admin.container.outdoor.index', compact('sessions', 'stats'));
   }

   public function requests()
   {
      return view('admin.container.requests.index');
   }

   public function complaints()
   {
      return view('admin.container.complaints.index');
   }

   public function notifications()
   {
      $broadcasts = Broadcast::with('sender')->latest()->paginate(10);
      return view('admin.container.notifications.index', compact('broadcasts'));
   }

   public function storeBroadcast(Request $request)
   {
      $request->validate([
         'audience' => 'required|string',
         'message' => 'required|string',
      ]);

      Broadcast::create([
         'audience' => $request->audience,
         'message' => $request->message,
         'sender_id' => auth()->id(),
      ]);

      return redirect()->route('admin.notifications')->with('success', 'Broadcast sent successfully.');
   }

   public function reports()
   {
      return view('admin.container.reports.index');
   }
}
