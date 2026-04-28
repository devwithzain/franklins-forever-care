<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Models\User;
use App\Models\ClientRequest;
use App\Models\Client;
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

        return view('client.dashboard.container.home.dashboard', [
            'title' => 'Client Dashboard - Franklin\'s Forever Care',
            'user' => $user,
            'clientRecord' => $clientRecord,
            'requests' => $requests,
        ]);
    }

    public function requests(Request $request)
    {
        $clientRecord = Client::where('user_id', Auth::id())->first();
        $query = ClientRequest::with(['client.user'])->where('client_id', $clientRecord->id ?? 0)->latest();
        $activeTab = $request->query('tab', 'all');
        if ($activeTab !== 'all') {
            $query->where('type', $activeTab);
        }
        $requests = $query->paginate(10)->appends(['tab' => $activeTab]);
        
        $stats = [
            'total' => ClientRequest::where('client_id', $clientRecord->id ?? 0)->count(),
            'change_agent' => ClientRequest::where('client_id', $clientRecord->id ?? 0)->where('type', 'Change Agent')->count(),
            'outdoor' => ClientRequest::where('client_id', $clientRecord->id ?? 0)->where('type', 'Outdoor Access')->count(),
            'cancellations' => ClientRequest::where('client_id', $clientRecord->id ?? 0)->where('type', 'Cancellations')->count(),
        ];

        return view('client.dashboard.container.requests.index', compact('requests', 'stats', 'activeTab'));
    }

    public function carePlan()
    {
        $clientRecord = Client::with('agent')->where('user_id', Auth::id())->first();
        return view('client.dashboard.container.care-plan.index', compact('clientRecord'));
    }

    public function notifications()
    {
        return view('client.dashboard.container.notifications.index');
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
}
