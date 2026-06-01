<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Basic',
                'price' => '$49',
                'amount' => 49.00,
                'duration' => '/mo',
                'features' => [
                    'Weekly Check-ins',
                    'Basic Health Monitoring',
                    'Medication Reminders',
                    '24/7 Phone Support'
                ],
                'color' => '#E8F5E9',
                'text_color' => '#4CAF50',
                'popular' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Standard',
                'price' => '$99',
                'amount' => 99.00,
                'duration' => '/mo',
                'features' => [
                    'Daily Check-ins',
                    'Advanced Health Monitoring',
                    'Medication Management',
                    'Doctor Appointment Scheduling',
                    '24/7 Priority Phone Support'
                ],
                'color' => '#FFF3E0',
                'text_color' => '#FF9800',
                'popular' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Premium',
                'price' => '$199',
                'amount' => 199.00,
                'duration' => '/mo',
                'features' => [
                    'Twice Daily Check-ins',
                    'Comprehensive Health Tracking',
                    'Full Medication Management',
                    'Transportation to Appointments',
                    'Weekly In-Home Care Visit',
                    '24/7 Video Consultation Support'
                ],
                'color' => '#E3F2FD',
                'text_color' => '#2196F3',
                'popular' => false,
                'status' => 'active',
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(
                ['name' => $pkg['name']],
                $pkg
            );
        }
    }
}
