<?php

namespace App\Services;

use App\Models\User;
use App\Models\Client;
use App\Models\Employee;
use App\Models\ServiceBooking;
use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getDashboardSummary(?Carbon $start, ?Carbon $end): array
    {
        return [
            'total_clients' => Client::whereBetween('created_at', [$start, $end])->count(),
            'total_employees' => Employee::whereBetween('created_at', [$start, $end])->count(),
            'active_bookings' => ServiceBooking::whereBetween('created_at', [$start, $end])->whereIn('status', ['confirmed', 'in_progress'])->count(),
            'pending_bookings' => ServiceBooking::whereBetween('created_at', [$start, $end])->where('status', 'pending')->count(),
            'unassigned_bookings' => ServiceBooking::whereBetween('created_at', [$start, $end])->whereNull('agent_id')->whereIn('status', ['pending', 'confirmed'])->count(),
            'completed_services' => ServiceBooking::whereBetween('created_at', [$start, $end])->where('status', 'completed')->count(),
            'open_complaints' => Complaint::whereBetween('created_at', [$start, $end])->where('status', 'Pending')->count(),
            'resolved_complaints' => Complaint::whereBetween('created_at', [$start, $end])->where('status', 'Resolved')->count(),
        ];
    }

    public function getOperationalReports(?Carbon $start, ?Carbon $end): array
    {
        // Workload & Assignment Distribution
        $employeeWorkloads = User::where('role', 'employee')
            ->withCount(['assignedBookings' => function ($q) use ($start, $end) {
                $q->whereBetween('created_at', [$start, $end])
                  ->whereIn('status', ['confirmed', 'in_progress']);
            }])
            ->get()
            ->map(function ($employee) {
                return [
                    'name' => $employee->name,
                    'active_bookings' => $employee->assigned_bookings_count
                ];
            })
            ->sortByDesc('active_bookings')
            ->take(10)
            ->values()
            ->toArray();

        // Booking Status Breakdown
        $bookingStatuses = ServiceBooking::whereBetween('created_at', [$start, $end])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        return [
            'employee_workloads' => $employeeWorkloads,
            'booking_statuses' => $bookingStatuses,
        ];
    }

    public function getClientAndComplaintReports(?Carbon $start, ?Carbon $end): array
    {
        $complaints = Complaint::whereBetween('created_at', [$start, $end])->get();

        $total = $complaints->count();
        $byStatus = $complaints->groupBy('status')->map->count();
        $byPriority = $complaints->groupBy('priority')->map->count();

        // Complaints per PCA
        $pcaComplaints = Complaint::whereBetween('created_at', [$start, $end])
            ->whereNotNull('employee_id')
            ->with('employee')
            ->get()
            ->groupBy('employee_id')
            ->map(function ($group) {
                return [
                    'employee_name' => $group->first()->employee->name,
                    'count' => $group->count()
                ];
            })
            ->sortByDesc('count')
            ->take(10)
            ->values()
            ->toArray();

        return [
            'total' => $total,
            'by_status' => $byStatus->toArray(),
            'by_priority' => $byPriority->toArray(),
            'pca_complaints' => $pcaComplaints,
        ];
    }

    public function getUserGrowthAndActivity(?Carbon $start, ?Carbon $end): array
    {
        $dates = [];
        $current = $start->copy();
        while ($current <= $end) {
            $dates[] = $current->format('Y-m-d');
            $current->addDay();
        }

        // Get DB driver
        $driver = DB::connection()->getDriverName();
        $dateFormat = $driver === 'sqlite' ? "strftime('%Y-%m-%d', created_at)" : "DATE_FORMAT(created_at, '%Y-%m-%d')";

        $newClients = Client::whereBetween('created_at', [$start, $end])
            ->select(DB::raw("{$dateFormat} as date"), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $newBookings = ServiceBooking::whereBetween('created_at', [$start, $end])
            ->select(DB::raw("{$dateFormat} as date"), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $newComplaints = Complaint::whereBetween('created_at', [$start, $end])
            ->select(DB::raw("{$dateFormat} as date"), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill in missing dates
        $chartData = [
            'dates' => $dates,
            'clients' => [],
            'bookings' => [],
            'complaints' => []
        ];

        foreach ($dates as $date) {
            $chartData['clients'][] = $newClients[$date] ?? 0;
            $chartData['bookings'][] = $newBookings[$date] ?? 0;
            $chartData['complaints'][] = $newComplaints[$date] ?? 0;
        }

        return $chartData;
    }
}