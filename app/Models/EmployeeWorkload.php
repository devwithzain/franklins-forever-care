<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeWorkload extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'active_bookings',
        'max_capacity',
        'workload_score',
    ];

    protected $casts = [
        'date' => 'date',
        'active_bookings' => 'integer',
        'max_capacity' => 'integer',
        'workload_score' => 'decimal:2',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isAvailable(): bool
    {
        return $this->active_bookings < $this->max_capacity;
    }

    public function getAvailableSlotsAttribute(): int
    {
        return max(0, $this->max_capacity - $this->active_bookings);
    }

    public static function calculateWorkloadScore(int $activeBookings, int $maxCapacity): float
    {
        if ($maxCapacity === 0) {
            return 100;
        }
        return round(($activeBookings / $maxCapacity) * 100, 2);
    }

    public static function updateWorkload(User $employee, \Carbon\Carbon $date): self
    {
        $workload = static::firstOrNew([
            'user_id' => $employee->id,
            'date' => $date->format('Y-m-d'),
        ]);

        // Count active bookings for this employee on this date
        $activeBookings = ServiceBooking::where('agent_id', $employee->id)
            ->whereDate('booking_date', $date)
            ->whereIn('status', ['confirmed', 'in_progress'])
            ->count();

        $workload->active_bookings = $activeBookings;
        $workload->workload_score = static::calculateWorkloadScore($activeBookings, $workload->max_capacity);
        $workload->save();

        return $workload;
    }
}
