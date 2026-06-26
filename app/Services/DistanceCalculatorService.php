<?php

namespace App\Services;

class DistanceCalculatorService
{
    /**
     * Calculates the distance between two points in miles using the Haversine formula.
     *
     * @param float|null $lat1
     * @param float|null $lon1
     * @param float|null $lat2
     * @param float|null $lon2
     * @return float|null Distance in miles, or null if any coordinate is missing.
     */
    public static function calculateDistanceInMiles($lat1, $lon1, $lat2, $lon2): ?float
    {
        if (is_null($lat1) || is_null($lon1) || is_null($lat2) || is_null($lon2)) {
            return null;
        }

        $earthRadiusMiles = 3958.8; // Earth radius in miles

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadiusMiles * $c;

        return $distance;
    }
}
