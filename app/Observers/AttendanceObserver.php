<?php

namespace App\Observers;

use App\Models\Attendance;
use App\Services\DistanceCalculatorService;

class AttendanceObserver
{
    /**
     * Handle the Attendance "saving" event.
     */
    public function saving(Attendance $attendance): void
    {
        $this->verifyLocation($attendance);
    }

    protected function verifyLocation(Attendance $attendance): void
    {
        // Now verifying location against the Patient (where the care is received)
        $patient = $attendance->patient;

        if (!$patient) {
            return;
        }

        $thresholdMiles = 0.5; // Max allowed distance to patient home
        $needsReview = false;

        // Verify Check-in
        if ($attendance->check_in_latitude && $attendance->check_in_longitude && $patient->latitude && $patient->longitude) {
            $distanceIn = DistanceCalculatorService::calculateDistanceInMiles(
                $attendance->check_in_latitude,
                $attendance->check_in_longitude,
                $patient->latitude,
                $patient->longitude
            );
            $attendance->check_in_distance_to_client = $distanceIn;

            if ($distanceIn > $thresholdMiles) {
                $needsReview = true;
            }
        }

        // Verify Check-out
        if ($attendance->check_out_latitude && $attendance->check_out_longitude && $patient->latitude && $patient->longitude) {
            $distanceOut = DistanceCalculatorService::calculateDistanceInMiles(
                $attendance->check_out_latitude,
                $attendance->check_out_longitude,
                $patient->latitude,
                $patient->longitude
            );
            $attendance->check_out_distance_to_client = $distanceOut;

            if ($distanceOut > $thresholdMiles) {
                $needsReview = true;
            }
        }

        if ($needsReview) {
            // Only update status if it's currently marked 'Present' or similar,
            // and don't overwrite if it's already 'Needs Review' or 'Location Mismatch'
            if ($attendance->status === 'Present') {
                $attendance->status = 'Needs Review';
            }
        }
    }

    /**
     * Handle the Attendance "created" event.
     */
    public function created(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "updated" event.
     */
    public function updated(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "deleted" event.
     */
    public function deleted(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "restored" event.
     */
    public function restored(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "force deleted" event.
     */
    public function forceDeleted(Attendance $attendance): void
    {
        //
    }
}
