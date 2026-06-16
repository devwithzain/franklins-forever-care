<?php

namespace App\Http\Controllers\Employee\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\OutdoorActivity;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OutdoorSessionController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'activity_name' => 'required|string|max:255',
            'activity_type' => 'required|string',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Verify that the selected client is actually assigned to this employee
        $client = Client::findOrFail($request->client_id);
        if ($client->agent_id !== $user->id) {
            return response()->json(['error' => 'You are not authorized to create a session for this client.'], 403);
        }

        // Ensure only one active session at a time
        $activeSession = OutdoorActivity::where('employee_id', $employee->id)
            ->where('status', 'Active')
            ->first();

        if ($activeSession) {
            return response()->json(['error' => 'You already have an active session.'], 400);
        }

        $session = OutdoorActivity::create([
            'employee_id' => $employee->id,
            'client_id' => $client->id,
            'activity_name' => $request->activity_name,
            'activity_type' => $request->activity_type,
            'location' => $request->location,
            'notes' => $request->notes,
            'start_time' => Carbon::now(),
            'status' => 'Active',
        ]);

        return response()->json(['message' => 'Session started successfully!', 'session' => $session]);
    }

    public function stop(Request $request, $id)
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();

        $session = OutdoorActivity::where('id', $id)
            ->where('employee_id', $employee->id)
            ->firstOrFail();

        if ($session->status !== 'Active') {
            return response()->json(['error' => 'Session is already completed.'], 400);
        }

        $endTime = Carbon::now();
        $durationMinutes = $session->start_time->diffInMinutes($endTime);

        $request->validate([
            'report_summary' => 'required|string',
            'report_participation_level' => 'required|string',
            'report_outcome_notes' => 'required|string',
            'report_follow_up_recommendations' => 'nullable|string',
        ]);

        $session->update([
            'status' => 'Completed',
            'end_time' => $endTime,
            'duration_minutes' => $durationMinutes,
            'report_summary' => $request->report_summary,
            'report_participation_level' => $request->report_participation_level,
            'report_outcome_notes' => $request->report_outcome_notes,
            'report_follow_up_recommendations' => $request->report_follow_up_recommendations,
        ]);

        return response()->json(['message' => 'Session stopped and report filed successfully!', 'session' => $session]);
    }
}
