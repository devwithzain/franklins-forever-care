<?php

namespace App\Services;

use App\Models\User;
use App\Models\ServiceBooking;
use App\Models\EmployeeWorkload;
use Carbon\Carbon;

class WorkloadBalancingService
{
    /**
     * Find the best available employee for a booking based on workload
     */
    public function findBestEmployee(ServiceBooking $booking): ?User
    {
        $bookingDate = $booking->preferred_date ?? Carbon::today();
        
        // Get all active employees (role = 'employee')
        $employees = User::where('role', 'employee')
            ->whereHas('employee', function ($query) {
                $query->where('status', 'active');
            })
            ->with(['workloads' => function ($query) use ($bookingDate) {
                $query->where('date', $bookingDate->format('Y-m-d'));
            }])
            ->get();

        $bestEmployee = null;
        $lowestScore = 100;

        foreach ($employees as $employee) {
            $workload = $employee->workloads->first();
            
            if (!$workload) {
                // Create workload record if doesn't exist
                $workload = EmployeeWorkload::updateWorkload($employee, $bookingDate);
            }

            // Check if employee has available slots
            if ($workload->isAvailable() && $workload->workload_score < $lowestScore) {
                $lowestScore = $workload->workload_score;
                $bestEmployee = $employee;
            }
        }

        return $bestEmployee;
    }

    /**
     * Assign booking to employee with workload balancing
     */
    public function assignWithBalancing(ServiceBooking $booking, ?User $employee = null): bool
    {
        // If no employee specified, find best match
        if (!$employee) {
            $employee = $this->findBestEmployee($booking);
        }

        if (!$employee) {
            return false;
        }

        // Assign employee to booking
        $booking->update([
            'agent_id' => $employee->id,
            'status' => 'confirmed',
            'booking_date' => $booking->preferred_date ?? Carbon::today(),
        ]);

        // Update workload
        EmployeeWorkload::updateWorkload($employee, $booking->preferred_date ?? Carbon::today());

        return true;
    }

    /**
     * Get workload statistics for dashboard
     */
    public function getWorkloadStats(Carbon $date = null): array
    {
        $date = $date ?? Carbon::today();

        $totalEmployees = User::where('role', 'employee')->count();
        $activeEmployees = User::where('role', 'employee')
            ->whereHas('employee', fn($q) => $q->where('status', 'active'))
            ->count();

        $workloads = EmployeeWorkload::where('date', $date->format('Y-m-d'))
            ->with('employee')
            ->get();

        $overloaded = $workloads->filter(fn($w) => $w->workload_score >= 80)->count();
        $available = $workloads->filter(fn($w) => $w->isAvailable())->count();
        $avgWorkload = $workloads->avg('workload_score') ?? 0;

        return [
            'total_employees' => $totalEmployees,
            'active_employees' => $activeEmployees,
            'overloaded_count' => $overloaded,
            'available_count' => $available,
            'average_workload' => round($avgWorkload, 2),
            'date' => $date->format('Y-m-d'),
        ];
    }

    /**
     * Get employees sorted by availability
     */
    public function getEmployeesByAvailability(Carbon $date = null)
    {
        $date = $date ?? Carbon::today();

        return User::where('role', 'employee')
            ->whereHas('employee', fn($q) => $q->where('status', 'active'))
            ->with(['workloads' => function ($query) use ($date) {
                $query->where('date', $date->format('Y-m-d'));
            }])
            ->get()
            ->map(function ($employee) use ($date) {
                $workload = $employee->workloads->first();
                
                if (!$workload) {
                    $workload = EmployeeWorkload::updateWorkload($employee, $date);
                }

                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'active_bookings' => $workload->active_bookings,
                    'max_capacity' => $workload->max_capacity,
                    'available_slots' => $workload->available_slots,
                    'workload_score' => $workload->workload_score,
                    'is_available' => $workload->isAvailable(),
                ];
            })
            ->sortBy('workload_score')
            ->values();
    }

    /**
     * Update all employee workloads for a specific date
     */
    public function updateAllWorkloads(Carbon $date = null): int
    {
        $date = $date ?? Carbon::today();
        $updated = 0;

        $employees = User::where('role', 'employee')->get();

        foreach ($employees as $employee) {
            EmployeeWorkload::updateWorkload($employee, $date);
            $updated++;
        }

        return $updated;
    }

    /**
     * Check if employee can take more bookings on a date
     */
    public function canAcceptBooking(User $employee, Carbon $date): bool
    {
        $workload = EmployeeWorkload::where('user_id', $employee->id)
            ->where('date', $date->format('Y-m-d'))
            ->first();

        if (!$workload) {
            return true; // No workload record means available
        }

        return $workload->isAvailable();
    }

    /**
     * Get overloaded employees (workload score > 80%)
     */
    public function getOverloadedEmployees(Carbon $date = null)
    {
        $date = $date ?? Carbon::today();

        return User::where('role', 'employee')
            ->whereHas('employee', fn($q) => $q->where('status', 'active'))
            ->with(['workloads' => function ($query) use ($date) {
                $query->where('date', $date->format('Y-m-d'));
            }])
            ->get()
            ->filter(function ($employee) {
                $workload = $employee->workloads->first();
                return $workload && $workload->workload_score >= 80;
            })
            ->map(function ($employee) {
                $workload = $employee->workloads->first();
                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'workload_score' => $workload->workload_score,
                    'active_bookings' => $workload->active_bookings,
                ];
            });
    }
}
