<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\User;
use App\Models\Client;
use App\Models\ServiceBooking;
use App\Models\Broadcast;
use App\Models\AdminNotification;
use App\Models\Reminder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Services\WorkloadBalancingService;

class AdminHomePageController extends Controller
{
   protected NotificationService $notificationService;
   protected WorkloadBalancingService $workloadService;

   public function __construct(
      NotificationService $notificationService,
      WorkloadBalancingService $workloadService
   ) {
      $this->notificationService = $notificationService;
      $this->workloadService = $workloadService;
   }

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
         'unassigned_bookings' => ServiceBooking::whereNull('agent_id')->whereIn('status', ['pending', 'confirmed'])->count(),
      ];

      // Growth calculation (comparing this month to last month)
      $lastMonthClients = Client::whereMonth('created_at', now()->subMonth()->month)->count();
      $stats['client_growth'] = $lastMonthClients > 0
         ? round((($stats['total_clients'] - $lastMonthClients) / $lastMonthClients) * 100)
         : 100;

      $recentActivities = ServiceBooking::with(['service', 'user', 'agent'])
         ->latest()
         ->take(5)
         ->get();

      // Get notification counts
      $notificationCounts = $this->notificationService->getUnreadCount();

      // Get recent unread notifications
      $recentNotifications = $this->notificationService->getRecentUnread(5);

      // Get workload stats
      $workloadStats = $this->workloadService->getWorkloadStats();

      // Fetch dynamic reminders sorted by completion status and date
      $reminders = Reminder::orderBy('is_completed', 'asc')
         ->orderBy('due_date', 'asc')
         ->orderBy('due_time', 'asc')
         ->get();

      // Fetch upcoming and recent bookings formatted for interactive calendar
      $calendarBookings = ServiceBooking::with(['service', 'user'])
         ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
         ->whereNotNull('preferred_date')
         ->get()
         ->map(function ($b) {
             return [
                 'id' => $b->id,
                 'patient_name' => $b->patient_name,
                 'service_title' => $b->service->title ?? $b->service->name ?? 'Service',
                 'date' => $b->preferred_date ? $b->preferred_date->format('Y-m-d') : null,
                 'plan_type' => $b->plan_type,
                 'type' => 'booking'
             ];
         })
         ->values();

      return view('admin.container.home.dashboard', [
         'title' => "Admin Dashboard – Franklin's Forever Care",
         'stats' => $stats,
         'recentActivities' => $recentActivities,
         'notificationCounts' => $notificationCounts,
         'recentNotifications' => $recentNotifications,
         'workloadStats' => $workloadStats,
         'reminders' => $reminders,
         'calendarBookings' => $calendarBookings,
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
        $notifications = $this->notificationService->getAllForUser(null);
        $notificationCounts = $this->notificationService->getUnreadCountForUser(null);
        return view('admin.container.notifications.index', compact('broadcasts', 'notifications', 'notificationCounts'));
    }

    public function storeBroadcast(Request $request)
    {
        $request->validate([
            'audience' => 'required|string',
            'message' => 'required|string',
        ]);

        $broadcast = Broadcast::create([
            'audience' => $request->audience,
            'message' => $request->message,
            'sender_id' => auth()->id(),
        ]);
        
        $this->notificationService->notifyBroadcast($broadcast);

        return redirect()->route('admin.notifications')->with('success', 'Broadcast sent successfully.');
    }

    public function markAsRead($id)
    {
        $this->notificationService->markAsRead($id, null);
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        $this->notificationService->markAllAsReadForUser(null);
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

   public function reports()
   {
      return view('admin.container.reports.index');
   }

   public function storeReminder(Request $request)
   {
      $data = $request->validate([
         'title' => 'required|string|max:255',
         'description' => 'nullable|string',
         'due_date' => 'required|date',
         'due_time' => 'nullable',
      ]);

      $reminder = Reminder::create($data);

      if ($request->ajax()) {
         return response()->json([
            'success' => true,
            'message' => 'Reminder created successfully.',
            'reminder' => $reminder
         ]);
      }

      return redirect()->route('admin.dashboard')->with('success', 'Reminder created successfully.');
   }

   public function toggleReminder(Reminder $reminder, Request $request)
   {
      $reminder->update([
         'is_completed' => !$reminder->is_completed,
      ]);

      if ($request->ajax()) {
         return response()->json([
            'success' => true,
            'message' => 'Reminder status updated.',
            'is_completed' => $reminder->is_completed
         ]);
      }

      return back()->with('success', 'Reminder status updated.');
   }

   public function deleteReminder(Reminder $reminder, Request $request)
   {
      $reminder->delete();

      if ($request->ajax()) {
         return response()->json([
            'success' => true,
            'message' => 'Reminder deleted successfully.'
         ]);
      }

      return back()->with('success', 'Reminder deleted successfully.');
   }
}
