<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Models\User;
use App\Models\ClientRequest;
use App\Models\Client;
use App\Models\ServiceBooking;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClientHomePageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $clientRecord = Client::with('agent')->where('user_id', $user->id)->first();

        $requests = ClientRequest::where('client_id', $clientRecord->id ?? 0)->latest()->take(5)->get();
        $bookings = ServiceBooking::where('user_id', $user->id)->latest()->take(5)->get();

        $stats = [
            'total_requests' => ClientRequest::where('client_id', $clientRecord->id ?? 0)->count(),
            'total_bookings' => ServiceBooking::where('user_id', $user->id)->count(),
            'active_plan' => ServiceBooking::where('user_id', $user->id)->where('status', 'confirmed')->first(),
        ];

        return view('client.dashboard.container.home.dashboard', [
            'title' => 'Client Dashboard - Franklin\'s Forever Care',
            'user' => $user,
            'clientRecord' => $clientRecord,
            'requests' => $requests,
            'bookings' => $bookings,
            'stats' => $stats,
        ]);
    }

    public function requests()
    {
        $user = Auth::user();

        $clientRecord = Client::where('user_id', $user->id)->first();

        $data = ClientRequest::where('client_id', $clientRecord->id ?? 0)
            ->latest()
            ->paginate(10);

        $stats = [
            'total_requests' => ClientRequest::where(
                'client_id',
                $clientRecord->id ?? 0
            )->count(),
        ];

        return view(
            'client.dashboard.container.requests.index',
            compact('data', 'stats')
        );
    }

    public function carePlan()
    {
        $user = Auth::user();
        $clientRecord = Client::with('agent')->where('user_id', $user->id)->first();
        $activeBookings = ServiceBooking::with('service')
            ->where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->latest()
            ->get();

        return view('client.dashboard.container.care-plan.index', compact('clientRecord', 'activeBookings'));
    }

    public function notifications()
    {
        $broadcasts = \App\Models\Broadcast::with('sender')->latest()->paginate(10);
        $notifications = Auth::user()->notifications()->latest()->paginate(10);
        return view('client.dashboard.container.notifications.index', compact('broadcasts', 'notifications'));
    }

    public function setting()
    {
        $user = Auth::user();
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($session) {
                return (object) [
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'user_agent' => $session->user_agent,
                    'last_activity' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                    'is_current_device' => $session->id === request()->session()->getId(),
                ];
            });

        return view('client.dashboard.container.setting.listings', [
            'user' => $user,
            'sessions' => $sessions,
            'title' => 'Settings - Franklin\'s Forever Care'
        ]);
    }

    public function updateSetting(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->id !== Auth::id()) {
                abort(403);
            }

            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'current_password' => 'required_with:password|string|nullable',
                'password' => ['nullable', 'confirmed', 'min:8'],
                'two_factor_enabled' => 'nullable|boolean',
            ]);

            if ($request->has('name')) {
                $user->name = $validatedData['name'];
            }

            if ($request->has('email') && $request->email !== $user->email) {
                $user->email = $validatedData['email'];
            }

            $user->two_factor_enabled = $request->has('two_factor_enabled');

            if ($request->hasFile('image')) {
                $storage = Storage::disk('public');
                if ($user->image && $storage->exists($user->image)) {
                    $storage->delete($user->image);
                }
                $imageName = 'profile/' . Str::random(32) . "." . $request->image->getClientOriginalExtension();
                $storage->put($imageName, file_get_contents($request->image->getRealPath()));
                $user->image = $imageName;
            }

            if (!empty($validatedData['password'])) {
                if (!isset($validatedData['current_password']) || !Hash::check($validatedData['current_password'], $user->password)) {
                    return back()->withErrors(['current_password' => 'Current password is incorrect']);
                }
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();
            return redirect()->back()->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function logoutSession($id)
    {
        DB::table('sessions')->where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Session terminated successfully.');
    }

    public function pcaAgent()
    {
        $user = Auth::user();
        $clientRecord = Client::with('agent.employee')->where('user_id', $user->id)->first();

        return view('client.dashboard.container.pca-agent.index', compact('clientRecord'));
    }

    public function rateAgent(Request $request, \App\Models\Employee $employee)
    {
        $user = Auth::user();
        $clientRecord = Client::where('user_id', $user->id)->first();

        if (!$clientRecord || $clientRecord->agent_id !== $employee->user_id) {
            abort(403, 'Unauthorized access.');
        }

        $validatedData = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        $employee->update([
            'rating' => $validatedData['rating'],
        ]);

        return redirect()->back()->with('success', 'Thank you! Your rating for your Personal Care Agent has been submitted.');
    }

    public function storeRequest(Request $request)
    {
        $user = Auth::user();
        $clientRecord = Client::where('user_id', $user->id)->first();
        if (!$clientRecord) {
            return redirect()->back()->with('error', 'Client record not found.');
        }

        $validatedData = $request->validate([
            'type' => 'required|string|in:Change Agent,Outdoor Access,Cancellations,General Support',
            'priority' => 'required|string|in:Low,Medium,High',
            'description' => 'required|string|min:10',
        ]);

        $customId = 'REQ-' . strtoupper(Str::random(8));

        ClientRequest::create([
            'client_id' => $clientRecord->id,
            'request_custom_id' => $customId,
            'type' => $validatedData['type'],
            'priority' => $validatedData['priority'],
            'description' => $validatedData['description'],
            'status' => 'Pending',
        ]);

        return redirect()->route('client.requests.index', ['tab' => 'requests'])->with('success', 'Support request submitted successfully!');
    }

    public function complaints()
    {
        $user = Auth::user();
        $clientRecord = Client::where('user_id', $user->id)->first();
        
        $complaints = \App\Models\Complaint::where('client_id', $clientRecord->id ?? 0)
            ->latest()
            ->paginate(10);

        return view('client.dashboard.container.complaints.index', compact('complaints'));
    }

    public function storeComplaint(Request $request)
    {
        $user = Auth::user();
        $clientRecord = Client::where('user_id', $user->id)->first();
        if (!$clientRecord) {
            return redirect()->back()->with('error', 'Client record not found.');
        }

        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|string|in:Low,Medium,High',
            'description' => 'required|string|min:10',
        ]);

        \App\Models\Complaint::create([
            'client_id' => $clientRecord->id,
            'subject' => $validatedData['subject'],
            'priority' => $validatedData['priority'],
            'description' => $validatedData['description'],
            'status' => 'Pending',
        ]);

        return redirect()->route('client.complaints.index')->with('success', 'Complaint registered successfully! Our care team will review this shortly.');
    }
}
