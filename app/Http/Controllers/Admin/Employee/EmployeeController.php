<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['user', 'clients'])->latest()->paginate(10);
        
        $stats = [
            'total' => Employee::count(),
            'active' => Employee::where('status', 'Active')->count(),
            'available' => Employee::where('status', 'Active')->count(), // For now same as active
            'on_leave' => Employee::where('status', 'On Leave')->count(),
        ];

        return view('admin.container.employees.index', compact('employees', 'stats'));
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
                'phone', 'ssn', 'region', 'type', 'status'
            ]));
        });

        return redirect()->route('admin.employees.index')->with('success', 'Agent updated successfully.');
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
