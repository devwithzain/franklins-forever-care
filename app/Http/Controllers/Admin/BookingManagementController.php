<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\User;
use App\Models\AdminNotification;
use App\Services\WorkloadBalancingService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingManagementController extends Controller
{
    protected WorkloadBalancingService $workloadService;
    protected NotificationService $notificationService;

    public function __construct(
        WorkloadBalancingService $workloadService,
        NotificationService $notificationService
    ) {
        $this->workloadService = $workloadService;
        $this->notificationService = $notificationService;
    }

    /**
     * Display all bookings with filters
     */
    public function index(Request $request)
    {
        $query = ServiceBooking::with(['user', 'service', 'agent']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->agent_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('preferred_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('preferred_date', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('patient_name', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($query) => $query->where('name', 'like', "%{$request->search}%"))
                  ->orWhereHas('service', fn($query) => $query->where('name', 'like', "%{$request->search}%"));
            });
        }

        $bookings = $query->latest()->paginate(15);

        // Get statistics
        $stats = [
            'total' => ServiceBooking::count(),
            'pending' => ServiceBooking::where('status', 'pending')->count(),
            'confirmed' => ServiceBooking::where('status', 'confirmed')->count(),
            'unassigned' => ServiceBooking::whereNull('agent_id')->whereIn('status', ['pending', 'confirmed'])->count(),
            'in_progress' => ServiceBooking::where('status', 'in_progress')->count(),
            'completed' => ServiceBooking::where('status', 'completed')->count(),
        ];

        // Get available agents for dropdown
        $agents = User::where('role', 'employee')
            ->whereHas('employee', fn($q) => $q->where('status', 'active'))
            ->get();

        return view('admin.bookings.index', compact('bookings', 'stats', 'agents'));
    }

    /**
     * Show booking details
     */
    public function show(ServiceBooking $booking)
    {
        $booking->load(['user', 'service', 'agent']);
        
        // Get workload info for assigned agent
        $agentWorkload = null;
        if ($booking->agent) {
            $agentWorkload = $booking->agent->workloads()
                ->where('date', $booking->preferred_date ?? Carbon::today())
                ->first();
        }

        return view('admin.bookings.show', compact('booking', 'agentWorkload'));
    }

    /**
     * Show assignment page for a booking
     */
    public function assignPage(ServiceBooking $booking)
    {
        $booking->load(['user', 'service']);

        // Get employees sorted by availability
        $employees = $this->workloadService->getEmployeesByAvailability($booking->preferred_date);

        // Find best match automatically
        $recommendedEmployee = $this->workloadService->findBestEmployee($booking);

        return view('admin.bookings.assign', compact('booking', 'employees', 'recommendedEmployee'));
    }

    /**
     * Assign employee to booking
     */
    public function assign(Request $request, ServiceBooking $booking)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        $agent = User::findOrFail($request->agent_id);

        // Check if agent can accept more bookings on this date
        $bookingDate = $booking->preferred_date ?? Carbon::today();
        if (!$this->workloadService->canAcceptBooking($agent, $bookingDate)) {
            return back()->withErrors(['agent_id' => 'This employee is at full capacity for the selected date.']);
        }

        // Assign the booking
        $success = $this->workloadService->assignWithBalancing($booking, $agent);

        if ($success) {
            // Create notification
            $this->notificationService->notifyAgentAssignment($booking, $agent);

            return redirect()->route('admin.bookings.index')
                ->with('success', "Booking assigned to {$agent->name} successfully.");
        }

        return back()->withErrors(['error' => 'Failed to assign booking. Please try again.']);
    }

    /**
     * Auto-assign best available employee to booking
     */
    public function autoAssign(ServiceBooking $booking)
    {
        $employee = $this->workloadService->findBestEmployee($booking);

        if (!$employee) {
            return back()->withErrors(['error' => 'No available employees found for this booking date.']);
        }

        $success = $this->workloadService->assignWithBalancing($booking, $employee);

        if ($success) {
            $this->notificationService->notifyAgentAssignment($booking, $employee);

            return redirect()->route('admin.bookings.index')
                ->with('success', "Booking auto-assigned to {$employee->name} based on workload balancing.");
        }

        return back()->withErrors(['error' => 'Failed to auto-assign booking.']);
    }

    /**
     * Bulk auto-assign unassigned bookings
     */
    public function bulkAutoAssign(Request $request)
    {
        $unassignedBookings = ServiceBooking::whereNull('agent_id')
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $assigned = 0;
        $failed = 0;

        foreach ($unassignedBookings as $booking) {
            if ($this->workloadService->assignWithBalancing($booking)) {
                $this->notificationService->notifyAgentAssignment(
                    $booking, 
                    User::find($booking->agent_id)
                );
                $assigned++;
            } else {
                $failed++;
            }
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', "Bulk assignment complete: {$assigned} assigned, {$failed} failed.");
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, ServiceBooking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated successfully.');
    }

    /**
     * Get unassigned bookings for dashboard widget
     */
    public function getUnassignedBookings()
    {
        $unassigned = ServiceBooking::whereNull('agent_id')
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['user', 'service'])
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'count' => ServiceBooking::whereNull('agent_id')
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),
            'bookings' => $unassigned->map(fn($b) => [
                'id' => $b->id,
                'patient_name' => $b->patient_name,
                'service_name' => $b->service?->name,
                'client_name' => $b->user?->name,
                'booking_date' => $b->preferred_date?->format('M d, Y'),
                'amount' => $b->amount,
            ]),
        ]);
    }

    /**
     * Get workload statistics for dashboard
     */
    public function getWorkloadStats()
    {
        $stats = $this->workloadService->getWorkloadStats();
        
        return response()->json($stats);
    }
}
