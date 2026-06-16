<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'active');

        $stats = [
            'total' => Employee::count(),
            'active' => Employee::where('status', 'Active')->count(),
            'available' => Employee::where('status', 'Active')->count(),
            'on_leave' => Employee::where('status', 'On Leave')->count(),
            'pending_apps' => \App\Models\CareerApplication::where('status', 'pending')->count(),
        ];

        if ($activeTab === 'applications') {
            $applications = \App\Models\CareerApplication::with('user')->latest()->paginate(10);
            return view('admin.container.employees.index', compact('applications', 'stats', 'activeTab'));
        }

        $employees = Employee::with(['user', 'clients'])->latest()->paginate(10);
        return view('admin.container.employees.index', compact('employees', 'stats', 'activeTab'));
    }

    public function create()
    {
        return view('admin.container.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'agent_custom_id' => 'required|unique:employees,agent_custom_id',
            'status' => 'required|in:Active,On Leave,Inactive',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password ?? 'password123'),
                'role' => 'employee',
            ]);

            Employee::create([
                'user_id' => $user->id,
                'agent_custom_id' => $request->agent_custom_id,
                'phone' => $request->phone,
                'ssn' => $request->ssn,
                'region' => $request->region,
                'type' => $request->type ?? 'Full-time',
                'status' => $request->status,
            ]);
        });

        return redirect()->route('admin.employees.index')->with('success', 'Agent created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('admin.container.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('admin.container.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user_id,
            'status' => 'required|in:Active,On Leave,Inactive',
        ]);

        DB::transaction(function () use ($request, $employee) {
            $employee->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $employee->update($request->only([
                'phone',
                'ssn',
                'region',
                'type',
                'status'
            ]));
        });

        return redirect()->route('admin.employees.index')->with('success', 'Agent updated successfully.');
    }

    public function showApplication($id)
    {
        $application = \App\Models\CareerApplication::findOrFail($id);
        return view('admin.container.employees.show-application', compact('application'));
    }

    public function approveApplication($id)
    {
        $application = \App\Models\CareerApplication::findOrFail($id);
        
        DB::transaction(function () use ($application) {
            $application->update(['status' => 'approved']);
            
            $user = $application->user;
            
            if (!$user) {
                // Check if user already exists with this email
                $user = \App\Models\User::where('email', $application->email)->first();
                
                if (!$user) {
                    $user = \App\Models\User::create([
                        'name' => $application->full_name,
                        'email' => $application->email,
                        'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(10)),
                        'role' => 'employee'
                    ]);
                }
                
                // Update application with user_id
                $application->update(['user_id' => $user->id]);
            }

            $user->update(['role' => 'employee']);
            
            Employee::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'agent_custom_id' => 'PCA-' . rand(1000, 9999),
                    'phone' => $application->phone,
                    'region' => $application->city . ', ' . $application->state,
                    'type' => 'Full-time',
                    'status' => 'Active',
                ]
            );
        });

        return redirect()->route('admin.employees.index', ['tab' => 'applications'])->with('success', 'Application approved and PCA agent created.');
    }

    public function destroy(Employee $employee)
    {
        DB::transaction(function () use ($employee) {
            $user = $employee->user;
            $employee->delete();
            $user->delete();
        });

        return redirect()->route('admin.employees.index')->with('success', 'Agent deleted successfully.');
    }
}
