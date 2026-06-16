<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Complaint;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SystemNotification;

class ComplaintWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_client_can_submit_complaint_linked_to_pca()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $clientUser = User::factory()->create(['role' => 'client']);
        $employeeUser = User::factory()->create(['role' => 'employee']);

        $client = Client::create([
            'user_id' => $clientUser->id,
            'client_custom_id' => 'C-123',
            'dob' => '1950-01-01',
            'phone' => '1234567890',
            'region' => 'North',
            'care_plan' => 'Basic',
            'agent_id' => $employeeUser->id,
            'status' => 'Active',
        ]);

        $response = $this->actingAs($clientUser)->post(route('client.complaints.store'), [
            'subject' => 'PCA is always late',
            'priority' => 'High',
            'description' => 'The assigned PCA has been late for the past 3 days.',
            'employee_id' => $employeeUser->id,
        ]);

        $response->assertRedirect(route('client.complaints.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('complaints', [
            'client_id' => $client->id,
            'employee_id' => $employeeUser->id,
            'subject' => 'PCA is always late',
            'priority' => 'High',
            'status' => 'Pending',
        ]);

        Notification::assertSentTo(
            [$admin],
            SystemNotification::class,
            function ($notification, $channels) {
                return $notification->type === 'complaint';
            }
        );
    }

    public function test_admin_can_resolve_complaint_and_record_resolver()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $clientUser = User::factory()->create(['role' => 'client']);
        $employeeUser = User::factory()->create(['role' => 'employee']);

        $client = Client::create([
            'user_id' => $clientUser->id,
            'client_custom_id' => 'C-123',
            'dob' => '1950-01-01',
            'phone' => '1234567890',
            'region' => 'North',
            'care_plan' => 'Basic',
            'agent_id' => $employeeUser->id,
            'status' => 'Active',
        ]);

        $complaint = Complaint::create([
            'client_id' => $client->id,
            'employee_id' => $employeeUser->id,
            'subject' => 'PCA is always late',
            'priority' => 'High',
            'description' => 'The assigned PCA has been late for the past 3 days.',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.complaints.updateStatus', $complaint->id), [
            'status' => 'Resolved',
        ]);

        $response->assertRedirect(route('admin.complaints'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'status' => 'Resolved',
            'resolved_by' => $admin->id,
        ]);
    }
}