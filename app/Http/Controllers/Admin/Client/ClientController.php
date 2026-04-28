<?php

namespace App\Http\Controllers\Admin\Client;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\Client\StoreClientRequest;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with(['user', 'agent'])->latest()->paginate(10);

        $stats = [
            'total' => Client::count(),
            'active_plans' => Client::where('status', 'Active')->count(),
            'pending_assignment' => Client::whereNull('agent_id')->count(),
            'critical_cases' => Client::where('status', 'Critical')->count(),
        ];

        return view('admin.container.clients.index', compact('clients', 'stats'));
    }
    public function create()
    {
        $agents = User::where('role', 'employee')->get();
        return view('admin.container.clients.create', compact('agents'));
    }
    public function store(StoreClientRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password ?? 'password123'),
                'role' => 'client',
            ]);

            Client::create([
                'user_id' => $user->id,
                'client_custom_id' => $request->client_custom_id ?? 'C-' . rand(1000, 9999),
                'dob' => $request->dob,
                'phone' => $request->phone,
                'region' => $request->region,
                'care_plan' => $request->care_plan,
                'agent_id' => $request->agent_id,
                'status' => $request->status,
            ]);
        });

        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }
    public function show(Client $client)
    {
        return view('admin.container.clients.show', compact('client'));
    }
    public function edit(Client $client)
    {
        $agents = User::where('role', 'employee')->get();
        return view('admin.container.clients.edit', compact('client', 'agents'));
    }
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $client->user_id,
            'status' => 'required|in:Active,Pending,Critical,Inactive',
        ]);

        DB::transaction(function () use ($request, $client) {
            $client->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $client->update($request->only([
                'dob',
                'phone',
                'region',
                'care_plan',
                'agent_id',
                'status'
            ]));
        });

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
    }
    public function destroy(Client $client)
    {
        DB::transaction(function () use ($client) {
            $user = $client->user;
            $client->delete();
            $user->delete();
        });

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully.');
    }
}
