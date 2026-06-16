<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class AssignmentWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_admin_can_view_unassigned_bookings()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $clientUser = User::factory()->create(['role' => 'client']);
        $service = Service::create(['title' => 'Home Care', 'slug' => 'home-care-1', 'short_description' => 'A test service', 'description' => 'Test Desc']);

        $booking = ServiceBooking::create([
            'service_id' => $service->id,
            'user_id' => $clientUser->id,
            'plan_type' => 'basic',
            'patient_name' => 'John Doe',
            'patient_age' => '70',
            'relationship' => 'Father',
            'address' => '123 Test St',
            'city' => 'Test City',
            'state' => 'TS',
            'zip_code' => '12345',
            'status' => 'pending',
            'amount' => 100,
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.bookings.index'));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
    }

    public function test_admin_can_assign_employee_to_booking()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $clientUser = User::factory()->create(['role' => 'client']);

        $employeeUser = User::factory()->create(['role' => 'employee']);
        Employee::create([
            'user_id' => $employeeUser->id,
            'agent_custom_id' => 'EMP1',
            'phone' => '123',
            'status' => 'active',
        ]);

        $service = Service::create(['title' => 'Home Care', 'slug' => 'home-care-2', 'short_description' => 'A test service', 'description' => 'Test Desc']);

        $booking = ServiceBooking::create([
            'service_id' => $service->id,
            'user_id' => $clientUser->id,
            'plan_type' => 'basic',
            'patient_name' => 'John Doe',
            'patient_age' => '70',
            'relationship' => 'Father',
            'address' => '123 Test St',
            'city' => 'Test City',
            'state' => 'TS',
            'zip_code' => '12345',
            'status' => 'pending',
            'amount' => 100,
            'payment_status' => 'paid',
            'preferred_date' => Carbon::tomorrow(),
        ]);

        $response = $this->actingAs($admin)->post(route('admin.bookings.assign.store', $booking->id), [
            'agent_id' => $employeeUser->id,
        ]);

        $response->assertRedirect(route('admin.bookings.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('service_bookings', [
            'id' => $booking->id,
            'agent_id' => $employeeUser->id,
            'status' => 'confirmed'
        ]);

        // Assert Notification sent
        Notification::assertSentTo(
            [$admin], // The notifyAgentAssignment method currently notifies admins.
            \App\Notifications\SystemNotification::class,
            function ($notification, $channels) {
                return $notification->type === 'agent_assigned';
            }
        );
    }
}
