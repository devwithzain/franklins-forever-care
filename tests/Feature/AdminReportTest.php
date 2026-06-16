<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\ServiceBooking;
use Carbon\Carbon;

class AdminReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_reports_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Create some sample data
        Client::create([
            'user_id' => User::factory()->create(['role' => 'client'])->id,
            'client_custom_id' => 'C-001',
            'dob' => '1950-01-01',
            'phone' => '1234567890',
            'region' => 'North',
            'care_plan' => 'Basic',
            'status' => 'Active',
            'created_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.reports', ['date_range' => 'this_month']));

        $response->assertStatus(200);
        $response->assertSeeText('Reports Analytics');
        $response->assertSee('New Clients');
        $response->assertSee('1'); // Should see the 1 client we just created
    }

    public function test_admin_can_export_reports_csv()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.reports.export.csv', ['date_range' => 'today']));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->assertHeader('Content-Disposition', 'attachment; filename=reports_' . Carbon::today()->format('Y-m-d') . '_to_' . Carbon::today()->endOfDay()->format('Y-m-d') . '.csv');
    }

    public function test_admin_can_export_reports_pdf()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.reports.export.pdf', ['date_range' => 'this_month']));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}