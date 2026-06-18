<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\ServiceBooking;
use App\Models\Service;
use Carbon\Carbon;

class AttendanceDistanceVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_attendance_status_is_present_when_close_to_client()
    {
        $employeeUser = User::factory()->create(['role' => 'employee']);
        $employee = Employee::create([
            'user_id' => $employeeUser->id,
            'agent_custom_id' => 'EMP-123'
        ]);

        $clientUser = User::factory()->create(['role' => 'client']);

        $patient = \App\Models\Patient::create([
            'user_id' => $clientUser->id,
            'name' => 'John Doe',
            'latitude' => 40.7128, // NY
            'longitude' => -74.0060
        ]);

        $service = Service::create(['title' => 'Home Care', 'slug' => 'home-care', 'price' => 100, 'description' => 'Test', 'category_id' => 1]);
        $booking = ServiceBooking::create([
            'service_id' => $service->id,
            'user_id' => $clientUser->id,
            'patient_id' => $patient->id,
            'plan_type' => 'Hourly',
            'patient_name' => 'John Doe',
            'patient_age' => '50',
            'relationship' => 'Self',
            'address' => '123 Main St',
            'city' => 'NY',
            'state' => 'NY',
            'zip_code' => '10001',
        ]);

        $attendance = Attendance::create([
            'employee_id' => $employee->id,
            'patient_id' => $patient->id,
            'service_booking_id' => $booking->id,
            'check_in' => Carbon::now(),
            'check_in_latitude' => 40.7129, // Very close
            'check_in_longitude' => -74.0061,
            'status' => 'Present',
        ]);

        $this->assertEquals('Present', $attendance->fresh()->status);
        $this->assertNotNull($attendance->fresh()->check_in_distance_to_client);
        $this->assertLessThan(0.5, $attendance->fresh()->check_in_distance_to_client);
    }

    public function test_attendance_status_is_needs_review_when_far_from_client()
    {
        $employeeUser = User::factory()->create(['role' => 'employee']);
        $employee = Employee::create([
            'user_id' => $employeeUser->id,
            'agent_custom_id' => 'EMP-124'
        ]);

        $clientUser = User::factory()->create(['role' => 'client']);

        $patient = \App\Models\Patient::create([
            'user_id' => $clientUser->id,
            'name' => 'John Doe',
            'latitude' => 40.7128, // NY
            'longitude' => -74.0060
        ]);

        $service = Service::create(['title' => 'Home Care', 'slug' => 'home-care-2', 'price' => 100, 'description' => 'Test', 'category_id' => 1]);
        $booking = ServiceBooking::create([
            'service_id' => $service->id,
            'user_id' => $clientUser->id,
            'patient_id' => $patient->id,
            'plan_type' => 'Hourly',
            'patient_name' => 'John Doe',
            'patient_age' => '50',
            'relationship' => 'Self',
            'address' => '123 Main St',
            'city' => 'NY',
            'state' => 'NY',
            'zip_code' => '10001',
        ]);

        $attendance = Attendance::create([
            'employee_id' => $employee->id,
            'patient_id' => $patient->id,
            'service_booking_id' => $booking->id,
            'check_in' => Carbon::now(),
            'check_in_latitude' => 40.8128, // Far away
            'check_in_longitude' => -74.1060,
            'status' => 'Present',
        ]);

        $this->assertEquals('Needs Review', $attendance->fresh()->status);
        $this->assertNotNull($attendance->fresh()->check_in_distance_to_client);
        $this->assertGreaterThan(0.5, $attendance->fresh()->check_in_distance_to_client);
    }
}
